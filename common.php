//写调试日志
function logwrite($txt,$rewrite = 0){
    if($rewrite){
        $log = fopen("uploads/log.txt", "w");
    }else{
        $log = fopen("uploads/log.txt", "a");
    }
    fwrite($log,$txt);
    fclose($log);
}

/**
 * curl请求，wbj
 */ 

function curl_request($url, $isPost = FALSE, $postData = NULL, $useCert = FALSE, $sslCertPath = NULL, $sslKeyPath = NULL)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    if ($isPost) {
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    if ($useCert) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLCERT, $sslCertPath);
        curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($curl, CURLOPT_SSLKEY, $sslKeyPath);
    } else {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    }
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}



/*
 * 确定时间与当前时间对比
*/
function compareTime($time){
    $now    = time();
    $step   = $now - $time;
    $min    = abs($step/60);
    $hour   = abs($min/60);
    $day    = abs($hour/24);
    $month  = abs($day/30);
    $year   = abs($day/365);
    if($min < 60){
        if(intval($min) != 0){
            $return = intval($min).'分钟';
        }
    }elseif($hour < 24){
        $return = intval($hour).'小时';
    }elseif($day < 30){
        $return = inval($day).'天';
    }elseif{$month < 12}{
        $return = inval($month).'月';
    }else{
        $return = inval($year).'年';
    }
    if($step > 0){
        $return $return.'前';
    }else{
        $return $return.'后';
    }
    if(intval($min)==0){
        if($step > 0){
            $return = '刚刚';
        }else{
            $return = '马上';
        }
    }
    return $return;
}

/**
 * 根据时间戳返回星期几
 * @param string $time 时间戳
 * @return 星期几
 */
function weekday($time)
{
    if(is_numeric($time))
    {
        $weekday = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        return $weekday[date('w', $time)];
    }
    return false;
}


/*
 * 接口返回
*/
function back($code,$msg="",$data=[]){
	$result = [
		'code'		=>		$code,
		'msg'		=>		$msg,
		'data'		=>		$data		
	];
	echo json_encode($result);
	exit;
}
/*
 * 检查表单输入信息是否存在
 * @params $insert [];要验证数组
*/
function checkInput($insert){
    $input = input();
    $data = [];
    $keys = array_keys($input);
    //输入键值只能为string
    foreach ($keys as $key => $value) {
        if(gettype($value)!='string') return back(0,'参数错误');
    }
    foreach ($insert as $key => $value) {
        if(in_array($value,$keys)){
            $data[$value] = $input[$value];
        }else{
            return back(0,'参数'.$value.'不存在');
        }
    }
    return $data;
}


//检查银行卡号是否正确
function check_bankCard($card_number){
    $arr_no = str_split($card_number);
    $last_n = $arr_no[count($arr_no)-1];
    krsort($arr_no);
    $i = 1;
    $total = 0;
    foreach ($arr_no as $n){
        if($i%2==0){
            $ix = $n*2;
            if($ix>=10){
                $nx = 1 + ($ix % 10);
                $total += $nx;
            }else{
                $total += $ix;
            }
        }else{
            $total += $n;
        }
        $i++;
    }
    $total -= $last_n;
    $x = 10 - ($total % 10);
    if($x == $last_n){
        return true;
    }else{
        return false;
    }
}
/**
 * md5简单加密
 */
function md5_encode($code)
{
    $code = \str_replace('e', '*', $code);
    $code = \str_replace('d', 'e', $code);
    $code = \str_replace('4', 'd', $code);
    $code = \str_replace('1', '4', $code);
    $code = \str_replace('a', '1', $code);
    $code = \str_replace('*', 'a', $code);
    return $code;
}
/**
 * 更改图片大小
 */
function changeImgSize($img, $maxsize)
{
    if (!file_exists($img)) {
        return false;
    }
    $oldimg = \think\Image::open($img);
    $oldimg->thumb($maxsize, $maxsize)->save($img);
}
/**
 * md5简单解密
 */
function md5_decode($code)
{
    $code = \str_replace('a', '*', $code);
    $code = \str_replace('1', 'a', $code);
    $code = \str_replace('4', '1', $code);
    $code = \str_replace('d', '4', $code);
    $code = \str_replace('e', 'd', $code);
    $code = \str_replace('*', 'e', $code);
    return $code;
}
//时间戳转时分秒
function time_to_his($time){
    $s = $time % 60;
    $m = floor($time % 3600);
    $h = floor($time % 86400);
    return $h.':'.$m.':'.$s;
}
/**
 * 处理微信名特殊符号
*/
function emoji_encode($nickname){
    $strEncode = '';
    $length = mb_strlen($nickname,'utf-8');
    for ($i=0; $i < $length; $i++) {
        $_tmpStr = mb_substr($nickname,$i,1,'utf-8');
        if(strlen($_tmpStr) >= 4){
            $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
        }else{
            $strEncode .= $_tmpStr;
        }
    }
    return $strEncode;
}

/**
 * 解码微信名特殊符号
*/

function emoji_decode($nickname){
    $arr = explode('[[EMOJI:', $nickname);
    $strDecode = $nickname;
    if(count($arr) > 1){
        $arr1 = explode(']]', $arr[1]);
        if($arr1[0]){
            $arr1[0] = rawurldecode($arr1[0]);
            $strDecode = $arr[0].$arr1[0].$arr1[1];
        }
    }
    return $strDecode;
}

/**
 * 删除当前目录及其目录下的所有目录和文件
 * @param string $path 待删除的目录
 * @note  $path路径结尾不要有斜杠/(例如:正确[$path='./static/image'],错误[$path='./static/image/'])
 */
function deleteDir($path) {

    if (is_dir($path)) {
        //扫描一个目录内的所有目录和文件并返回数组
        $dirs = scandir($path);

        foreach ($dirs as $dir) {
            //排除目录中的当前目录(.)和上一级目录(..)
            if ($dir != '.' && $dir != '..') {
                //如果是目录则递归子目录，继续操作
                $sonDir = $path.'/'.$dir;
                if (is_dir($sonDir)) {
                    //递归删除
                    deleteDir($sonDir);

                    //目录内的子目录和文件删除后删除空目录
                    @rmdir($sonDir);
                } else {

                    //如果是文件直接删除
                    @unlink($sonDir);
                }
            }
        }
        @rmdir($path);
    }
}
/**
 * 去除字符串html标签
 * @param [type] $string
 * @return void
 */
function cutstr_html($string){  
    $string = strip_tags($string);
    $string = trim($string);  
    $string = str_replace("\t","",$string); 
    $string = str_replace("\r\n","",$string);  
    $string = str_replace("\r","",$string);  
    $string = str_replace("\n","",$string);  
    $string = str_replace(" ","",$string);  
    return trim($string);  
}

