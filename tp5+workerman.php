<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/workerman/workerman/Autoloader.php';
require_once __DIR__ . '/thinkphp/base.php';
$database = require_once __DIR__ . '/app/database.php';
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
function addressApply($lat,$lng,$uid){
	global $db;
	$res = $db->name('User')->where('id',$uid)->update(['location' => json_encode(['lat' => $lat, 'lng' => $lng])]);
	if($res){
		return true;
	}else{
		return false;
	}
	
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
    global $ws_worker, $global_uid;
    // 为这个连接分配一个uid
    $connection->uid = ++$global_uid;
    echo "new connection from ip " . $connection->getRemoteIp() . "\n";
};

//接收数据
$ws_worker->onMessage = function($connection, $data)
{
    global $ws_worker,$db;
	$data = json_decode($data);
	//判断请求身份
	if(empty($connection->sd_uid)){
		if(empty($data->access_token)){
			$connection->send(json_encode(['code'=>401,'msg'=>'params access_token false']));
		}else{
			$user = $db->name('user')->alias('u')->join('runner r','u.id = r.uid')->field('u.store_id,u.store_id,u.id,r.type,r.audit,r.status,r.listening')->where('u.access_token',$data->access_token)->find();
			$connection->sd_uid = $user['id'];
			$connection->sd_store_id = $user['store_id'];
			if($user['audit'] == 1 && $user['status'] == 1 && $user['listening'] == 1){
				$connection->sd_type = $user['type'];
				$connection->sd_runner = 1;
			}else{
				$connection->sd_runner = 0;
			}

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
				$res = addressApply($data->lat,$data->lng,$connection->sd_uid);
				if($res){
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
			    	if($conn->sd_store_id == $connection->sd_store_id && $conn->sd_type == $data->type){
			        	$conn->send(json_encode(['code'=>409,'msg'=>'you have new order!']));
			    	}else{
			        	$conn->send(json_encode(['code'=>400,'msg'=>'common success']));
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
