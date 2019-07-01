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
