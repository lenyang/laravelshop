<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class Order extends Model
{
    //
	protected $table = 'order';
	public $timestamps = false;
	protected $fillable = ['member_id', 'addtime', 'total_price', 'pay_method', 'shipping_method', 'shr_name', 'shr_tel', 'shr_address', 'shr_province', 'shr_city', 'shr_area'];


	public function before_add_to_order($buythis,$request){
		//订单完成之前要先查询库存是否足够

		$input = [];

		$member_id = session('member_id');

		$error = '';

		if(!$member_id){

			$error = '必须先登陆';

			return ['error' =>$error ];

		}

		if(empty($buythis)){

			$error = '订单中没有商品,无法下单';

			return ['error' =>$error ];
		}


		$data = (new Cart())->get_cart_data();

		$cartList = $data['cartList'];

		//读取库存之前先枷锁
		$this->fp = fopen('./order.lock','r');

		flock($this->fp, LOCK_EX);

		$total_price = 0;

		$total_goods_number = 0;

		foreach ($cartList as $index => $item) {
			if(!in_array($item['goods_id'].'-'.$item['goods_attr_ids'],$buythis)){
				continue;
			}

			$attr_name = $this->get_goods_attr_ids_name($item['goods_attr_ids']);

			//找到这件商品的库存
			$goods_number_left = DB::table('goods_number')
				->where('goods_attr_ids', '=', $item['goods_attr_ids'])
				->where('goods_id', '=', $item['goods_id'])
				->lists('goods_number');

			//如果这件商品没有设置库存,返回库存不足的提示,并清空buythis
			if(empty($goods_number_left)){

				$error = '<strong style="color: red;font-size: 40px">'.$item['goods_name'].'--'.$attr_name[0]->name.'库存不足</strong>';

				//买不了,将session中的buythis给删掉
				$request->session()->forget('buythis');

				return ['error'=>$error];
			}
			if($goods_number_left[0]<$item['goods_number']){
				$error = '<strong style="color: red;font-size: 40px">'.$item['goods_name'].'库存不足</strong>';

				//买不了,将session中的buythis给删掉
				$request->session()->forget('buythis');

				return ['error'=>$error];

			}

			$total_price += $item['singlePri'];

			$total_goods_number += $item['goods_number'];

		}

		$input['total_price'] = $total_price;

		$input['tatal_goods_number'] = $total_goods_number;

		$input['addtime'] = time();

		$input['member_id'] = $member_id;


		return [
			'input' => $input,
			'error' => 'no'
		];
	}

	public function add_goods_order($buythis, $order_id, $request){
		$data = (new Cart())->get_cart_data();

		$member_id = session('member_id');

		$cartList = $data['cartList'];


		foreach ($cartList as $index => $item) {
			if (!in_array($item['goods_id'] . '-' . $item['goods_attr_ids'], $buythis)) {
				continue;
			}
			$res = DB::table('order_goods')
				->insert([
					'order_id'   		=>  $order_id,
					'goods_id'   		=>  $item['goods_id'],
					'goods_attr_ids'    =>  $item['goods_attr_ids'],
					'goods_number'      =>  $item['goods_number'],
					'price'             =>  $item['xiaoji']
 				]);

			if(!$res){
				DB::rollBack();
			}

			// 减少库存

			$res = DB::table('goods_number')
					->where('goods_id', '=', $item['goods_id'])
					->where('goods_attr_ids', '=', $item['goods_attr_ids'])
					->decrement('goods_number', $item['goods_number']);

			if(!$res){
				DB::rollBack();
			}
		}
     //提交
		DB::commit();
		//释放所
		flock($this->fp,LOCK_UN);
		fclose($this->fp);

		//清空购物车中已买的商品
		foreach ($cartList as $index => $item) {
			if (!in_array($item['goods_id'] . '-' . $item['goods_attr_ids'], $buythis)) {
				continue;
			}
			DB::table('cart')
					->where('goods_id', '=', $item['goods_id'])
					->where('goods_attr_ids', '=', $item['goods_attr_ids'])
					->where('member_id', '=', $member_id)
					->delete();
			}
		//清空session($buythis)
		$request->session()->forget('buythis');
	}

	public function get_goods_attr_ids_name($data){

		$attrs = explode(',', $data);

        return $attr_name =  DB::table('goods_attr')
				 ->whereIn('id', $attrs)
				 ->select(DB::raw("GROUP_CONCAT(attr_value) as name"))
				 ->get();

	}
}
