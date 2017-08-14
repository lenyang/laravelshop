<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    //
	protected $table = 'category';
	protected $fillable = ['cat_name', 'parent_id'];
	public $timestamps = false;


	/**
	 * 无限分类取数据
	 */
	public function _getTree($data, $p_id=0, $level=0){
		static $arr = array();
		foreach($data as $k=>$v){
			if($v['parent_id'] == $p_id){
				$v['level'] = $level;
				$arr[] = $v;
				$this->_getTree($data, $v['id'], $level+1);
			}
		}
		return $arr;
	}

	/**
	 * 取出权限分类下的数据
	 */
	public function getTree(){
		$data = $this->get();
		return $navData =  $this->_getTree($data);

	}

	/**
	 * 将得到的分类数组进行处理,方便前台循环
	 *
	 * @return array
	 */
	public function handle_category_data(){
		$navData = $this->getTree();
		$arr = array();
		foreach($navData as $k=>$v){
			if($v->parent_id==0){
			$sub = array();
			foreach($navData as $k1=>$v1){
				if($v1->parent_id==$v->id){
					$children = array();
						foreach($navData as $k2=>$v2){

							if($v2->parent_id==$v1->id){
									$children[] = $v2;
													}
				$v1->children = $children;
									}
					$sub[]=$v1;
					}
					$v['sub'] = $sub;
				}
					$arr[] = $v;
			}

		}
		return $arr;
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function get_category_goods($id){
		return $data = DB::table('goods')
				->where('cat_id', '=', $id)
				->get();
	}

	/**
	 * @param $cat_id
	 *
	 * @return mixed
	 */
	public function getGoodsIdByCatId($cat_id){
		return $data = DB::table('goods')
				->where('cat_id', '=', $cat_id)
				->lists('id');
	}

	/**
	 * 通过分类id制作搜索条件
	 *
	 * @param $cat_id
	 *
	 * @return array
	 */
	public function getSearchConditionByCatId($cat_id){
		$res = [];
		//找出这个分类下的所有商品id
		$goodsIds = $this->getGoodsIdByCatId($cat_id);

		/***************价格区间段*******************/
		//默认是6段
		$priceCount = 6;
		//找出这些商品的最大值和最小值
		$priceInfo = DB::table('goods')
				->whereIn('id', $goodsIds)
				->select(DB::raw('MAX(shop_price) as max_price'),DB::raw('MIN(shop_price) as min_price'))
				->get();

		$priceSection = $priceInfo[0]->max_price - $priceInfo[0]->min_price;

		if(count($goodsIds)>1){
			if($priceSection<100){
				$priceCount = 2;
			}elseif($priceSection<1000){
				$priceCount = 4;
			}elseif($priceSection<10000){
				$priceCount = 6;
			}else{
				$priceCount = 7;
			}
		}

		//根据段数分段,存储价格区间
		$price = [];

		//每段的价格区间
		$pricePerSection = $priceSection/$priceCount;

		$first_price = floor($priceInfo[0]->min_price);

		for($i=0;$i<$priceCount;$i++){
            if($i<$priceCount-1){
				$start = floor(($first_price/100)*100);
				$end = $first_price+$pricePerSection;
				//将每段的末尾价格进行取整
				$end = floor(($end/100)*100-1);
			}else{
				$start = floor(($first_price/100)*100);
				$end = $first_price+$pricePerSection;
				//将每段的末尾价格进行取整
				$end = ceil(($end/100)*100);
			}


			$price[] = $start.'-'.$end;

			$first_price += $pricePerSection;
		}
		$res['price'] =$price;
		/*************商品属性*************/
		$attrs = DB::table('goods_attr as a')
				->leftJoin('attribute as b', 'b.id', '=', 'a.attr_id')
				->whereIn('goods_id', $goodsIds)
				->orderBy('b.id')
				->select(DB::raw('distinct php32_a.attr_id'), 'a.attr_value', 'b.attr_name')
				->get();



		//将这个数组进行一下处理,每个attr_id一样的构造放在一起,做成三维数组
		$attrData = [];
		foreach ($attrs as $attr) {
			$attrData[$attr->attr_id][] = $attr;
		}
		$res['attrs'] = $attrData;

		return $res;
	}

	/**
	 * 通过商品id制作搜索条件
	 *
	 * @param $goodsIds
	 *
	 * @return array
	 */
	public function getSearchConditionByGodsId($goodsIds){
		$res = [];


		/***************价格区间段*******************/
		//默认是6段
		$priceCount = 6;
		//找出这些商品的最大值和最小值
		$priceInfo = DB::table('goods')
				->whereIn('id', $goodsIds)
				->select(DB::raw('MAX(shop_price) as max_price'),DB::raw('MIN(shop_price) as min_price'))
				->get();

		$priceSection = $priceInfo[0]->max_price - $priceInfo[0]->min_price;

		if(count($goodsIds)>1){
			if($priceSection<100){
				$priceCount = 2;
			}elseif($priceSection<1000){
				$priceCount = 4;
			}elseif($priceSection<10000){
				$priceCount = 6;
			}else{
				$priceCount = 7;
			}
		}

		//根据段数分段,存储价格区间
		$price = [];

		//每段的价格区间
		$pricePerSection = $priceSection/$priceCount;

		$first_price = floor($priceInfo[0]->min_price);

		for($i=0;$i<$priceCount;$i++){
			if($i<$priceCount-1){
				$start = floor(($first_price/100)*100);
				$end = $first_price+$pricePerSection;
				//将每段的末尾价格进行取整
				$end = floor(($end/100)*100-1);
			}else{
				$start = floor(($first_price/100)*100);
				$end = $first_price+$pricePerSection;
				//将每段的末尾价格进行取整
				$end = ceil(($end/100)*100);
			}


			$price[] = $start.'-'.$end;

			$first_price += $pricePerSection;
		}
		$res['price'] =$price;
		/*************商品属性*************/
		$attrs = DB::table('goods_attr as a')
				->leftJoin('attribute as b', 'b.id', '=', 'a.attr_id')
				->whereIn('goods_id', $goodsIds)
				->orderBy('b.id')
				->select(DB::raw('distinct php32_a.attr_id'), 'a.attr_value', 'b.attr_name')
				->get();

		//将这个数组进行一下处理,每个attr_id一样的构造放在一起,做成三维数组
		$attrData = [];

		foreach ($attrs as $attr) {
			$attrData[$attr->attr_id][] = $attr;
		}

		$res['attrs'] = $attrData;

		return $res;
	}

}
