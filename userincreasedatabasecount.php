/*
 * 用户增长数据统计
*/
	public function userIncrease(){
		$userlist = Db::name('user')->field('id,create_time')->where(['store_id'=>$this->store_id])->order('id desc')->select();
		$all['day'] 	= [];
		$all['month']  	= [];
		$all['year']	= [];
		$year = substr(date('Y-m'), 0,4);
		for ($i=0; $i < 7; $i++) { 
			$all['day'][$i]['date'] = date('Y-m-d',strtotime('-'.$i.'day',strtotime(date('Y-m-d'))));
			$all['day'][$i]['time'] = strtotime('-'.$i.'day',strtotime(date('Y-m-d'))); 
			$all['day'][$i]['count'] = 0; 

			$all['month'][$i]['date'] = date('Y-m',strtotime('-'.$i.'month',strtotime(date('Y-m'))));
			$all['month'][$i]['time'] = strtotime('-'.$i.'month',strtotime(date('Y-m'))); 
			$all['month'][$i]['count'] = 0; 

			$all['year'][$i]['date'] = date('Y',strtotime('-'.$i.'year',strtotime($year.'-01-01')));
			$all['year'][$i]['time'] = strtotime('-'.$i.'year',strtotime($year.'-01-01'));
			$all['year'][$i]['count'] = 0;
		}
		//七日数据
		$daylist   = $userlist;
		$monthlist = $userlist;
		$yearlist  = $userlist;
		foreach ($all['day'] as $k => &$v) {
			foreach ($daylist as $key => $value) {
				if($value['create_time'] > $v['time']){
					$v['count'] ++;
					unset($daylist[$key]);
				}else{
					break;
				}
			}
			unset($v['time']);
		}
		//七月数据
		foreach ($all['month'] as $k => &$v) {
			foreach ($monthlist as $key => &$value) {
				if($value['create_time'] > $v['time']){
					$v['count'] ++;
					unset($monthlist[$key]);
				}else{
					break;
				}
			}
			unset($v['time']);
		}
		//七年数据
		foreach ($all['year'] as $k => &$v) {
			foreach ($yearlist as $key => &$value) {
				if($value['create_time'] > $v['time']){
					$v['count'] ++;
					unset($yearlist[$key]);
				}else{
					break;
				}
			}
			unset($v['time']);
		}
		return return_json(0,'获取成功',$all);
	}
