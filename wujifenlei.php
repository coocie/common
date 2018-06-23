    /*
     * 无极分类
     * */
    public function wj($items){
        $items = $this->convert_arr_key($items,'id');
        $tree = [];
        foreach ($items as $k => $item)
            if ($item['pid'] == 0){
                $tree[] = &$items[$k];
            }
            else{
                $items[$item['pid']]['sub'][] = &$items[$k];

            }
        return $tree;
    }
    /**
     * @param $arr
     * @param $id
     * @return array
     * 将数据库中查出的列表以指定的 id 作为数组的键名
     */
    function convert_arr_key($arr, $key_name)
    {
        $result = array();
        foreach($arr as $key => $val){
            $result[$val[$key_name]] = $val;
        }
        return $result;
    }
