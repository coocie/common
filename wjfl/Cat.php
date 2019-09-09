<?php

namespace app\admin\controller;

use think\Db;

// 建材分类

class Cat extends Base
{
    public function index()
    {
        $list = Db::name('cat')->where(['status' => 1])->order('sort')->select();
        foreach ($list as $key => $value) {
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
        }
        return view('', ['list' => json_encode($list)]);
    }
    /**
     * 获取分类
     */
    public function getlist()
    {
        $list = Db::name('cat')->where(['status' => 1])->order('sort')->select();
        // $data = $this->dueList($list);
        return back(200, '获取成功', $list);
    }
    /**
     * 循环分类
     */
    private function dueList($list, $pid = 0)
    {
        $data = [];
        foreach ($list as  $value) {
            if ($value['pid'] != $pid) {
                continue;
            }
            if ($value['is_end'] == 0) {
                $value['li'] = $this->dueList($list, $value['id']);
            }
            $data[] = $value;
        }
        return $data;
    }
    /**
     * 编辑分类
     */
    public function saveCat()
    {
        $sort = 0;
        $data = json_decode(input('data'),true);
        $pids = []; //用于修改pid is_end字段，避免重复
        //获取所有分类id
        $ids = Db::name('cat')->where('status', 1)->column('id');
        Db::startTrans();
        try {
            foreach ($data as $value) {
                $value['pid'] = $value['pid'] ? $value['pid'] : 0;
                $sort++;
                //有一个小问题，前端用的是ztree树插件http://www.treejs.cn/v3/main.php#_zTreeInfo生成的id是虫101开始的，所以用tid区分，把前端返回的tid变成id,把parent_id变成pid
                $tid = str_replace('treeDemo_', '', $value['tid']);
                $pid = str_replace('treeDemo_', '', $value['parent_tid']);
                //如果已存在，就修改如果不存在就添加,因为tid是随前端变化而变化的，所以没有用tid做id
                $value['jc_id'] = isset($value['jc_id'])?$value['jc_id']:0;
                if (in_array($value['jc_id'], $ids)) {
                    Db::name('cat')->where('id', $value['jc_id'])->update(['tid' => $tid, 'name' => $value['name'], 'status' => 1, 'sort' => $sort, 'pid' => $pid, 'is_end' => 1]);
                } else {
                    Db::name('cat')->insert(['tid' => $tid, 'name' => $value['name'], 'status' => 1, 'sort' => $sort, 'pid' => $pid, 'is_end' => 1]);
                }
                //如果不是一级分类，就给上级级分类is_end设置0；
                if ($pid > 1) {
                    if (!in_array($pid, $pids)) { //避免重复修改
                        $pids[] = $pid;
                        Db::name('cat')->where(['tid' => $pid])->update(['is_end' => 0]);
                    }
                }
            }
            Db::commit();
            return back(200, '修改成功');
        } catch (\Throwable $th) {
            return Db::rollback(409, '修改失败');
        }
    }
}
