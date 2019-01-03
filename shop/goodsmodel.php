<?php
namespace app\shop\model;

use think\Db;
use think\Cache;
use think\Log;
use think\Model;

class ShopGoods extends Model{
    protected $type = [
        'pics'=>'json'
    ];

/*
 * 关联表
*/
    public function cat(){
        return $this->hasOne('ShopCat','id','cid')->field('id,name,sort'); 
    }
    public function attr(){
        return $this->hasMany('ShopGoodsAttr','gid','id')->where('is_del',0)->field('id,attr,content'); 
    }
    public function spec(){
        return $this->hasMany('ShopGoodsSpec','gid','id')->where('is_del',0)->field('id,name,num,price,img'); 
    }

	public function add($data,$sid){
		$category = model('shop_cat')->where(['id'=>$data['cid'],'is_del'=>0])->find();//判断分类
		if(!$category){back(0,'分类选择错误');}
		$goodsName = $this->where(['name'=>$data['name']])->find();
		if($goodsName){back(0,'商品名已存在');}
		Db::startTrans();
		try{
		    $goodsId = $this->insertGetId([
		    	'sid'		=>	$sid,
		    	'name'		=>	$data['name'],
		    	'pic'		=>	$data['pic'],
		    	'pics'		=>	json_encode($data['pics']),
		    	'des'		=>	$data['des'],
		    	'cid'		=>	$data['cid'],
		    	'sort'		=>	$data['sort'],
		    	'create_time'=>	time(),
		    	'content'	=>	$data['content'],
		    	'freight'	=>  $data['freight']
		    ]);
		    //添加属性
		    // $attr = json_decode($data['attr'],true);
		    $attr = $data['attr'];
		    if(!$attr){back(0,'属性参数错误');}
		    $attrlist = [];
		    foreach ($attr as $key => $value) {
		    	//属性名不可重复
		    	if(!in_array($value['attr'], $attrlist)){
		    		model('shop_goods_attr')->insert([
		    			'gid'		=>	$goodsId,
		    			'attr'		=>	$value['attr'],
		    			'content'	=>	$value['content']
		    		]);
		    		$attrlist[] = $value['attr'];
		    	}else{
		    		Db::rollback();
		    		back(0,'属性名不可重复');
		    	}
		    }
		    //规格
		    // $spec = json_decode($data['spec'],true);
		    $spec = $data['spec'];
		    $speclist = [];
		    if(!$spec){back(0,'规格参数错误');}
		    foreach ($spec as $key => $value) {
		    	//属性名不可重复
		    	if(!in_array($value['name'], $speclist)){
		    		model('shop_goods_spec')->insert([
		    			'gid'		=>	$goodsId,
		    			'price'		=>	$value['price'],
		    			'name'		=>	$value['name'],
		    			'num'		=>	$value['num'],
		    			'img'		=>	$value['img']
		    		]);
		    		$speclist[] = $value['name'];
		    	}else{
		    		Db::rollback();
		    		back(0,'规格名不可重复');
		    	}
		    }
		    // 提交事务
		    Db::commit();
	    	back(1,'添加成功');
	    } catch (\Exception $e) {
	    	errOut($e);
	    	Db::rollback();
	    	back(0,'添加失败');
	    }
	}

/*
 * 修改商品
*/
	public function edit($data,$sid){
		$id = $data['id'];
		unset($data['id']);
		$res = $this->where(['id'=>$id,'sid'=>$sid])->find();
		if(!$res){back(0,'商品不存在');}
		$category = model('shop_cat')->where(['id'=>$data['cid'],'is_del'=>0])->find();//判断分类
// dump($res);die;
		if(!$category){back(0,'分类选择错误');}
		$goodsName = $this->where(['sid'=>$sid,'name'=>$data['name'],'id'=>['<>',$id]])->find();
		if($goodsName){back(0,'商品名已存在');}
		Db::startTrans();
		try{
		    $this->where('id',$id)->update([
		    	'sid'	=>	$sid,
		    	'name'		=>	$data['name'],
		    	'pic'		=>	$data['pic'],
		    	'pics'		=>	json_encode($data['pics']),
		    	'des'		=>	$data['des'],
		    	'cid'		=>	$data['cid'],
		    	'sort'		=>	$data['sort'],
		    	'content'	=>	$data['content'],
		    	'freight'	=>  $data['freight']
		    ]);


		    //修改属性
		    // $attr = json_decode($data['attr'],true);
		    $attr = $data['attr'];
		    if(!$attr){back(0,'属性参数错误');}
		    $oldAttrids = model('shop_goods_attr')->where(['gid'=>$id,'is_del'=>0])->field('id,attr')->select();//旧有属性
		    $newAttrids = array_column($attr,'id');
		    //删除提交过来不存在属性
		    foreach ($oldAttrids as $key => $value) {
		    	if (!in_array($value['id'], $newAttrids)) {
		    		model('shop_goods_attr')->where(['id'=>$value['id']])->update(['is_del'=>1]);
		    	}
		    }
		    $attrlist = [];
		    foreach ($attr as $key => $value) {
		    	//属性名不可重复
		    	if(!in_array($value['attr'], $attrlist)){
		    		if($value['id'] == 0){
			    		model('shop_goods_attr')->insert([
			    			'gid'		=>	$id,
			    			'attr'		=>	$value['attr'],
			    			'content'	=>	$value['content']
			    		]);
		    		}else{
			    		model('shop_goods_attr')->where('id',$value['id'])->update([
			    			'gid'		=>	$id,
			    			'attr'		=>	$value['attr'],
			    			'content'	=>	$value['content']
			    		]);
		    		}
		    		$attrlist[] = $value['attr'];
		    	}else{
		    		Db::rollback();
		    		back(0,'属性名不可重复');
		    	}
		    }


		    //修改规格
		    // $spec = json_decode($data['spec'],true);
		    $spec = $data['spec'];
		    if(!$spec){back(0,'规格参数错误');}
		    $oldSpecids = model('shop_goods_spec')->where(['gid'=>$id,'is_del'=>0])->field('id,name')->select();//旧有规格
		    $newSpecids = array_column($spec,'id');
		    //删除提交过来不存在规格
		    foreach ($oldSpecids as $key => $value) {
		    	if (!in_array($value['id'], $newSpecids)) {
		    		model('shop_goods_spec')->where(['id'=>$value['id']])->update(['is_del'=>1]);
		    	}
		    }
		    $speclist = [];
		    foreach ($spec as $key => $value) {
		    	//属性名不可重复
		    	if(!in_array($value['name'], $speclist)){
		    		if($value['id'] == 0){
			    		model('shop_goods_spec')->insert([
			    			'gid'		=>	$id,
			    			'price'		=>	$value['price'],
			    			'name'		=>	$value['name'],
			    			'num'		=>	$value['num'],
		    				'img'		=>	$value['img']
			    		]);
		    		}else{
			    		model('shop_goods_spec')->where('id',$value['id'])->update([
			    			'gid'		=>	$id,
			    			'price'		=>	$value['price'],
			    			'name'		=>	$value['name'],
			    			'num'		=>	$value['num'],
		    				'img'		=>	$value['img']
			    		]);
		    		}
		    		$speclist[] = $value['name'];
		    	}else{
		    		Db::rollback();
		    		back(0,'规格名不可重复');
		    	}
		    }

		    // 提交事务
		    Db::commit();
	    	back(1,'修改成功');
	    } catch (\Exception $e) {
	    	echo $e->getMessage();
	    	Db::rollback();
	    	back(0,'修改失败');
	    }
	}

	/*
 	 * 获取订单列表
	*/
	public function getGoodsList($sid,$is_del){
		$paginate = input('paginate')?input('paginate'):10;
		$cid = input('cid')?input('cid'):0;//分类
		$where = ['sid'=>$sid];
		if($cid != 0){
			$where = array_merge($where,['cid'=>$cid]);
		}
		if($is_del == 0 || $is_del == 1){
			$where = array_merge($where,['is_del'=>$is_del]);
		}
		$list = $this
			->where($where)
			->order('sort desc')
			->paginate($paginate);
		foreach ($list as $key => &$value) {
			$value->cat;
			$value->attr;
			$value->spec;
		}
		back(1,'获取成功',$list);
	}
/*
 * 获取订单详情
*/
	public function getGoodsInfo($data,$sid){
		$data = $this->where(['id'=>$data['id'],'sid'=>$sid])->find();
		if(!$data){
			back(0,'获取失败');
		}
		$data->cat;
		$data->attr;
		$data->spec;
		back(1,'获取成功',$data);
	}
}
