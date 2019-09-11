    public function addvideo(){

        $file = request()->file('file');
        $id = input('id');
        $name = input('name');
        $chunk = input('chunk');
        $chunks = input('chunks');
        $info = $file->move('uploads/video/temporary/'.$id,$name.$chunk);
        // $a = $info->getSaveName();
        // $imgp = str_replace("\\", "/", $a);
        // $imgpath = 'uploads/video/temporary/' . $imgp;//临时路径
        $response = array();
        if ($info) {
            $file = '';
            if($chunk == $chunks-1){
                $ext = str_replace('video/','',input('type'));
                $file = $this->connectVideo($id,$name,$chunks,$ext);
            }
            $response['isSuccess'] = true;
            $response['f'] = $file;
        } else {
            $response['isSuccess'] = false;
        }
        echo json_encode($response);
    }
    /**
     * 拼接视频文件
     */
    public function connectVideo($id,$name,$chunks,$ext){
        $filename = "uploads/video/v/".time().rand(1111,9999).'.'.$ext;
        $video = fopen($filename, "a");
        for ($i=0; $i < $chunks; $i++) { 
            $inputFile = 'uploads/video/temporary/'.$id.'/'.$name.$i;
            if(file_exists($inputFile)){
                fwrite($video,file_get_contents($inputFile));
            }
        }
        fclose($video);
        return $filename;
    }
