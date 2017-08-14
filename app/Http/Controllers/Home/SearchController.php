<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController;
use App\Http\Model\Goods;
use Illuminate\Http\Request;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Toplan\FilterManager\FilterManager;

class SearchController extends HomeController
{
    //
	public function keySearch(Request $request, $key){


		if(!$key || $key=='请输入商品关键字'){
			return back()->withErrors('请填写搜索的商品名称');
		}
		$searchGoodsIds = (new Goods())->key_search($key);

		$searchGoodsIds = explode(',', $searchGoodsIds[0]->ids);

		$get = $request->all();

		$price = $request->price;
		if(!empty($price)){
			$price = explode('-',$price);
		}

		list($keys, $values) = array_divide($get);

		$attrGoodsId = null;
		foreach($keys as $k=>$v){
			if(strpos($v,'attr_')!==false){
				//将$key分开,得到属性id
				$attrId = str_replace('attr_','',$v);
				//取出属性值中的最后一个'-'号
				$attr_name = strrchr($values[$k],'-');

				$attr_value = str_replace($attr_name,'', $values[$k]);

				//根据属性id和属性值取出对应的商品id,1,2,3,4的格式
				$goodsIds = DB::table('goods_attr')
						->where('attr_id', '=', $attrId)
						->where('attr_value', '=', $attr_value)
						->select(DB::raw('GROUP_CONCAT(goods_id) gids'))
						->get();


				if($goodsIds[0]->gids){
					//这个属性有商品
					$gids['gids'] = explode(',',$goodsIds[0]->gids);

					if($attrGoodsId === null){
						//说明是第一个搜索的属性
						//将第一次搜索到的商品id暂存到$attrGoodsId中
						$attrGoodsId = $gids['gids'];

					}else{
						//证明不是第一次搜索的商品id,和第一次搜索的属性商品id取交集,如果交集为空
						//后面的也就不用再取了

						$attrGoodsId = array_intersect($attrGoodsId,$gids['gids']);

						if(empty($attrGoodsId)){
							break;
						}
					}
				}else{
					//表明这个属性没有相应的商品
					//先将前几次的id交集清空
					$attrGoodsId = [];

					break;
				}


			}
		}

		//执行到这,表明前几次的属性商品是有共同的商品id
		if($attrGoodsId){
		$attrGoodsId = array_intersect($searchGoodsIds, $attrGoodsId);
		}
		////取出已经支付的订单id
		$payed_order = DB::table('order')->where('pay_status','=','是')	->select(DB::raw('GROUP_CONCAT(id) ids'))->get();

		$payed_order = explode(',', $payed_order[0]->ids);


		//默认的排序名称
		$order_by = 'xl';
		//默认的排序方式
		$order_way = 'desc';

		if(isset($get['orderby'])) {

			$od_by = $get['orderby'];

			if ($od_by) {
				if ($od_by == 'addtime') {
					$order_by = 'a.addtime';
				} elseif (strpos($od_by, 'price_') !== false) {
					$order_by = 'a.shop_price';
					if ($od_by == 'price_asc') {

						$order_way = 'asc';

					}
				}
			}
		}

		if($attrGoodsId && $price){
			$GoodsData = DB::table('goods as a')
					->whereBetween('a.shop_price', $price)
					->whereIn('c.order_id', $payed_order)
					->whereIn('a.id', $attrGoodsId)
					->leftJoin(DB::raw('(select count(*) as num,goods_id from php32_comment GROUP BY php32_comment.goods_id) as php32_b'), 'b.goods_id', '=', 'a.id')
					->leftJoin('order_goods as c', 'c.goods_id', '=', 'a.id')
					->select('a.shop_price', 'a.addtime', 'a.sm_logo', 'a.goods_name', DB::raw('IFNULL(php32_b.num,1) as number'), DB::raw('IFNULL(SUM(php32_c.goods_number),0) xl'))
					->groupBy('c.goods_id')
					->orderBy($order_by, $order_way)
					->paginate(2);
		}elseif($attrGoodsId){

			$GoodsData = DB::table('goods as a')
					->leftJoin(DB::raw('(select count(*) as num,goods_id from php32_comment GROUP BY php32_comment.goods_id) as php32_b'), 'b.goods_id', '=', 'a.id')
					->leftJoin('order_goods as c', 'c.goods_id', '=', 'a.id')
					->whereIn('a.id', $attrGoodsId)
					->whereIn('c.order_id', $payed_order)
					->select('a.shop_price','a.addtime', 'a.sm_logo', 'a.goods_name', DB::raw('IFNULL(php32_b.num,1) as number'), DB::raw('IFNULL(SUM(php32_c.goods_number),0) xl'))
					->groupBy('c.goods_id')
					->orderBy($order_by, $order_way)
					->paginate(2);

		}elseif($price){
			$GoodsData = DB::table('goods as a')
					->whereBetween('a.shop_price', $price)
					->whereIn('a.id', $searchGoodsIds)
					->leftJoin(DB::raw('(select count(*) as num,goods_id from php32_comment GROUP BY php32_comment.goods_id) as php32_b'), 'b.goods_id', '=', 'a.id')
					->select('a.shop_price','a.addtime', 'a.sm_logo', 'a.goods_name', DB::raw('IFNULL(php32_b.num,1) as number'))
					->paginate(2);
		}elseif(!is_null($attrGoodsId)&& count($attrGoodsId)<1){

			$GoodsData= [];
		}else{

			$GoodsData = DB::table('goods as a')
					->leftJoin(DB::raw('(select count(*) as num,goods_id from php32_comment GROUP BY php32_comment.goods_id) as php32_b'), 'b.goods_id', '=', 'a.id')
					->leftJoin('order_goods as c', 'c.goods_id', '=', 'a.id')
					->whereIn('a.id', $searchGoodsIds)
					->select('a.shop_price', 'a.addtime', 'a.sm_logo', 'a.goods_name', DB::raw('IFNULL(php32_b.num,1) as number'), DB::raw('IFNULL(SUM(php32_c.goods_number),0) xl'))
					->groupBy('a.id')
					->orderBy($order_by, $order_way)
					->paginate(2);



		}
		$value = [];

		foreach ($keys as $key => $v) {
			$val = explode('-', $values[$key]);
			$value[]=$val;
		}



		$searchData = (new Category())->getSearchConditionByGodsId($searchGoodsIds);

		//取出侧面导航的分类信息
		$navData = (new Category)->handle_category_data();

		$data = $this->set_page_info('商品搜索页', '京西', '京西', '0', ['list'], ['list']);

		return view('home.search.search')->with(['data'=>$data, 'navData'=>$navData, 'searchData'=>$searchData, 'get_keys'=>$keys, 'get_values'=>$value, 'GoodsData'=>$GoodsData, 'order_way'=>$order_way, 'order_by'=>$order_by, 'key'=>$key]);

	}

}
