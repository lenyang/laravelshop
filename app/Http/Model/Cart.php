<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    //
	protected $table = 'cart';
	protected $fillable = ['goods_id', 'goods_attr_id', 'goods_number', 'member_id'];
	public $timestamps = false;

	/**
	 * 会员登陆后将cookie中的数据转入数据库
	 */
	public function moveCookieToDb(){
		$cartData = isset($_COOKIE['cartGoods'])?unserialize($_COOKIE['cartGoods']):[];

		$member_id = session('member_id');

        if(!empty($cartData)){
		foreach($cartData as $k=>$v){
			$arr = explode('-', $k);
			//判断该会员是否之前已经选过这件商品
			$has = DB::table('cart')
					->where('member_id', '=', $member_id)
					->where('goods_id', '=', $arr[0])
					->where('goods_attr_ids', '=', $arr[1])
					->lists('id');
			if($has){
				DB::table('cart')
						->where('member_id', '=', $member_id)
						->where('goods_id', '=', $arr[0])
						->where('goods_attr_ids', '=', $arr[1])
						->increment('goods_number', $v);
			}else{
			$res = DB::table('cart')
				->insert([
					'goods_id'       => $arr[0],
					'goods_attr_ids' => $arr[1],
					'goods_number'   => $v,
					'member_id'      => $member_id
				]);
			    }
		    }
		}

		setcookie('cartGoods', '', time()-1, '/');
	}

	public function get_cart_data(){

		//判断用户是否登陆,如果已经登陆了就从数据库取出对应的数据,否则就从cookie中取出在购物车中的商品
		$member_id = session('member_id');

		if ($member_id) {
			//从数据库中取出数据
			$carts = DB::table('cart')
					->where('member_id', '=', $member_id)
					->get();

			foreach($carts as $k=>$v){
				$cartData[] = [
						'goods_id' => $v->goods_id,
						'goods_attr_ids' => $v->goods_attr_ids,
						'goods_number' => $v->goods_number
				];
			}
		} else {
			//从cookie中取数据
			$cartGoods = isset($_COOKIE['cartGoods'])?unserialize($_COOKIE['cartGoods']):[];

			//$cartData = [];
			$res = [];
			foreach ($cartGoods as $k => $v) {
				$_k = explode('-', $k);
				$cartData[] = [
						'goods_id' => $_k[0],
						'goods_attr_ids' => $_k[1],
						'goods_number' => $v
				];
			}
		}
		$price = (new Member())->get_member_price($cartData[0]['goods_id']);


			//对cartData进行处理,在购物车列表页面展示
			$cartList = [];

			$total_price = 0;

			foreach ($cartData as $k => $v) {
				//根据商品id找出商品的信息
				$goods_info = DB::table('goods')->where('id', $v['goods_id'])->select('sm_logo', 'goods_name', 'shop_price')->get();

				$cartList[$k]['goods_name'] = $goods_info[0]->goods_name;

				$cartList[$k]['sm_logo'] = $goods_info[0]->sm_logo;

				$cartList[$k]['price'] = $price;

				$attrs = explode(',', $v['goods_attr_ids']);

				$xiaoji = 0;

				foreach ($attrs as $k1 => $v1) {
					$attrValue = DB::table('goods_attr as a')
							->where('a.id', '=', $v1)
							->leftJoin('attribute as b', 'a.attr_id', '=', 'b.id')
							->select('a.attr_price', 'b.attr_name', 'a.attr_value')
							->get();

					$xiaoji += $attrValue[0]->attr_price;

					$cartList[$k]['attr'][] = $attrValue;

					$cartList[$k]['xiaoji'] = $xiaoji+$price;
				}
				$cartList[$k]['singlePri'] = ($cartList[$k]['xiaoji'])*$v['goods_number'];

				$cartList[$k]['goods_id'] = $v['goods_id'];

				$cartList[$k]['goods_number'] = $v['goods_number'];

				$cartList[$k]['goods_attr_ids'] = $v['goods_attr_ids'];

				$total_price+= $cartList[$k]['singlePri'];
			}

         return array('cartList'=>$cartList, 'total_price'=>$total_price);
		}

}
