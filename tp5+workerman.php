<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/workerman/workerman/Autoloader.php';
require_once __DIR__ . '/thinkphp/base.php';
//授权数据库
$database =[
    'type' => 'mysql',
    'dsn' => '',
    'hostname' => '122.114.42.177',
    'database' => 'auth_4hl_cn',
    'username' => 'auth_4hl_cn',
    'password' => 'kF88jzManZ4BHtMi',
    'hostport' => '3306',
    'params' => [],
    'charset' => 'utf8',
    'prefix' => '',
    'debug'           => true,
    'deploy'          => 0,
    'rw_separate'     => false,
    'master_num'      => 1,
    'slave_no'        => '',
    'fields_strict'   => true,
    'resultset_type'  => 'array',
    'auto_timestamp'  => true,
    'datetime_format' => 'Y-m-d H:i:s',
    'sql_explain'     => false,
];
//var_dump($database);die;
use think\Db;
$db = Db::connect($database);//连接数据库
$list = [];

$ws_worker = new Worker("websocket://0.0.0.0:8899");//开启socket
// 启动1个进程对外提供服务
$ws_worker->count = 1;
$global_uid = 0;
//常规请求 30s   code 101
//地址请求 30s   code 102
function addressApply($lat,$lng,$domain,$access_token,$version){
	if($version == 1){
		$url = $domain.'/addons/sd_135K/core/api.php?s=socket/setAddr';
	}elseif($version == 2){
		$url = $domain.'/api.php?s=socket/setAddr';
	}
	$res = http_curl($url,['access_token'=>$access_token,'lat'=>$lat,'lng'=>$lng]);
	return $res;
}
//测试请求 0     code 103
//聊天请求 0     code 104
function chatApply(){
	return true;
}
//下单请求 0 code 105
//配送员订单完成请求 code 106

//进入连接
$ws_worker->onConnect = function($connection)
{	
	// var_dump($_SERVER);
    global $ws_worker, $global_uid,$db;
    // 为这个连接分配一个uid
    $connection->uid = ++$global_uid;
    //echo '当前连接数量：'.count($ws_worker->connections)."\n";
    //保存当前socket连接数量
    $db->table('sd_135k_socket')->where('id',1)->update(['socket'=>count($ws_worker->connections)]);
};
/*
 * 请求客户服务器
*/
function http_curl($url, $post_data = '', $timeout = 5){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    if ($post_data != '') {
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}
//获取用户服务器信息
/*
 * @param $domain 域名
 * @param $version 1独立版，2微擎版
*/
function getUserInfo($domain,$version,$access_token){
	if($version == 1){
		$url = $domain.'/addons/sd_135K/core/api.php?s=socket/getInfo';
	}elseif($version == 2){
		$url = $domain.'/api.php?s=socket/getInfo';
	}
	$userInfo = http_curl($url,['access_token'=>$access_token]);
	return $userInfo;
}
//接收数据
$ws_worker->onMessage = function($connection, $data)
{
    global $ws_worker,$db;
    $time = time();
    $domainList = $db->table('weby_authorize')->where(['time'=>['>',$time]])->column('domain');
	$data = json_decode($data);
	if(empty($data->code)){
		$connection->send(json_encode(['code'=>401,'msg'=>'params code false']));
		$connection->close();
		return;
	}elseif(empty($data->domain)){
		$connection->send(json_encode(['code'=>401,'msg'=>'params domain false']));
		$connection->close();
		return;
	}elseif(!in_array($data->domain, $domainList)){
		$connection->send(json_encode(['code'=>401,'msg'=>'domain is not authorized']));
		$connection->close();
		return;
	}elseif(empty($data->version)){
		$connection->send(json_encode(['code'=>401,'msg'=>'params version false']));
		$connection->close();
		return;
	}elseif(empty($data->access_token)){
		$connection->send(json_encode(['code'=>401,'msg'=>'params access_token false']));
		$connection->close();
		return;
	}
	//判断请求身份
	if(empty($connection->sd_store_id)){//没有记录
		$userInfo = getUserInfo($data->domain,$data->version,$data->access_token);
		//echo $userInfo.'-------'."\n";
		$userInfo = json_decode($userInfo);
		//var_dump($userInfo);
		if($userInfo->code == 0){
			$connection->send(json_encode(['code'=>401,'msg'=>'not find this user']));
			$connection->close();
			return;
		}else{
			$connection->sd_store_id = $userInfo->data->store_id;
			$connection->run_type    = $userInfo->data->run_type;//配送员类型
			$connection->domain 	 = $data->domain;				
		}
	}
	switch ($data->code) {
		case '101'://常规请求
			$connection->send(json_encode(['code'=>400,'msg'=>'common success']));
			break;		
		case '102'://地址请求
			if(empty($data->lat) || empty($data->lng)){
				$connection->send(json_encode(['code'=>401,'msg'=>'params lat or lng false']));
			}else{
				$res = addressApply($data->lat,$data->lng,$data->domain,$data->access_token,$data->version);
				$res = json_decode($res);
				if($res->code == 1){
					$connection->send(json_encode(['code'=>402,'msg'=>'address apply ok']));
				}else{
					$connection->send(json_encode(['code'=>403,'msg'=>'address apply flase']));
				}
			}
			break;		
		case '103'://测试请求
			$connection->send(json_encode(['code'=>400,'msg'=>'test success']));
			break;		
		case '104'://下单请求
			if(empty($data->type)){
				$connection->send(json_encode(['code'=>401,'msg'=>'params type false']));
			}else{
			    foreach($ws_worker->connections as $conn){
			    	if(!empty($conn->sd_store_id)){
				    	if($conn->sd_store_id == $connection->sd_store_id && $conn->domain == $data->domain && $conn->run_type == $data->type){
				        	$conn->send(json_encode(['code'=>409,'msg'=>'you have new order!']));
				    	}else{
				        	$conn->send(json_encode(['code'=>400,'msg'=>'common success']));
				    	}
			    	}
			    }
			}
			break;		
		case '105'://聊天请求
			$connection->send('connect ok');
			break;			
		default:
			# code...
			break;
	}

    // echo 'send \n';
};

//断开连接
$ws_worker->onClose = function($connection){
    global $ws_worker;
    // foreach($ws_worker->connections as $conn)
    // {
    //     $conn->send("user[{$connection->uid}] logout");
    // }
    echo 'close';
};

// 运行worker
Worker::runAll();
