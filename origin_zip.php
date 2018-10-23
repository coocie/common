/*
 * 插件安装
*/
	public function install(){
        $input = input();
        if(!isset($input['id']))return return_json(0,'参数id错误');else $id = $input['id'];
		$url  = config('authWeb').'/api.php/plug/install';
		$versionConfig = file_get_contents("../../addons/config.php");
		$baseVersion = $versionConfig['base_version']?$versionConfig['base_version']:'';
		$return  = http_curl($url,"id=".$id.'&base_version='.$base_version);
		$return = json_decode($return,ture);
		if($return['code'] == 1){
			if($return['data']['base'] != ''){
				$res = $this->getZip($return['data']['base'],'../core.zip');
				if($res > 0){
					$this->unzip_file('../core.zip','../');
				}
				dump($res);die;
			}
		}
	}

/*
 *获取zip文件
*/
	public function getZip($url,$path){
		$ch = curl_init();
		$timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);
        curl_close($ch);
        $res =file_put_contents($path,$content);
        return $res;
	}
/*
 * 解压zip
*/
	public function unzip_file($file, $destination){ 
		// 实例化对象 
		$zip = new \ZipArchive() ; 
		//打开zip文档，如果打开失败返回提示信息 
		if ($zip->open($file) !== TRUE) { 
		  die ("Could not open archive"); 
		} 
		//将压缩文件解压到指定的目录下 
		$zip->extractTo($destination); 
		//关闭zip文档 
		$zip->close(); 
	  	echo 'Archive extracted to directory'; 
	} 
