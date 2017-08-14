<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Cart;
use App\Http\Model\Member;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends HomeController
{
    //
	public function store(Request $request, Cart $cart){

		$input = $request->except('_token');

		$rules = [
			'goods_id'     => 'required',
			'goods_number' => 'required|numeric'
		];

		$message = [
			'goods_id.required'     => '必须选择一件商品',
			'goods_number.required' => '最少要选择一件商品',
			'goods_number.numeric'  => '选择的商品件数必须是数字'
		];

		$validator = Validator::make($input, $rules, $message);

		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}

		//判断用户是否已经登陆
		$member_id = session('member_id');

		sort($input['goods_attr_ids'], SORT_NUMERIC);

		$goods_attr_ids = implode(',', $input['goods_attr_ids']);

		if($member_id){
			//判断数据库中是否已经存在这件商品
			$has = DB::table('cart')
					->where('goods_id', '=', $input['goods_id'])
					->where('goods_attr_ids', '=', $goods_attr_ids)
					->where('member_id', '=', $member_id)
					->lists('id');

			if($has){
			//将这件商品的数量加上提交的商品数量即可
				$res = DB::table('cart')
					->where('id', '=', $has[0])
					->increment('goods_number', $input['goods_number']);
			}else {
				//将挑选的商品入库
				$res = DB::table('cart')
						->insert([
								'goods_id' => $input['goods_id'],
								'goods_attr_ids' => $goods_attr_ids,
								'goods_number' => $input['goods_number'],
								'member_id' => $member_id
						]);
			}
			if($res){
				return redirect('/cart/index')->withMsg('成功添加到购物车!');
			}else{
				return back()->withErrors('添加购物车失败!')->withInput();
			}
		}else{
			//会员没有登陆,将其存到cookie中
			$cartGoods = isset($_COOKIE['cartGoods'])?unserialize($_COOKIE['cartGoods']):[];

			//存在cookie中的数据格式商品id-商品属性id=>商品数量,方便登陆以后从cookie中的数据转移到数据库
			$goods_number = $input['goods_number'];

			$id = $input['goods_id'].'-'.$goods_attr_ids;

			//判断cookie中是否已经有了这件商品

			if(isset($cartGoods[$id])){

			$cartGoods[$id]+=$goods_number;

			}else{

			$cartGoods[$id] = $goods_number;

			}

			setcookie('cartGoods', serialize($cartGoods), time()+86400, '/');

			return redirect('/cart/index');
		}
	}

	public function index(Cart $cart)
	{

		$cartData    = $cart->get_cart_data();

		$cartList    = $cartData['cartList'];

		$total_price = $cartData['total_price'];

		$data = $this->set_page_info('京西商城', '京西', '京西', '0', ['cart'], ['cart1']);

		return view('home.cart.index')->with(['data'=>$data, 'cartList'=>$cartList, 'total_price'=>$total_price]);


	}

	public function ajaxUpdateGoods(Request $request){
		$input = $request->except('_token');

		$member_id = session('member_id');

		if($input['type']=='add'){
		//如果会员已经登陆,就修改数据库中的数量,点击一次就数量+1
		if($member_id){
			$res = DB::table('cart')
					->where('goods_id', '=', $input['gid'])
					->where('goods_attr_ids', '=', $input['gaid'])
					->increment('goods_number',1);
			if(!$res){
				return array(
					'status' => 0,
					'error'  => '修改购物车失败'
				);
			}

		}else{
			//操作cookie
			$cartGoods = isset($_COOKIE['cartGoods'])?unserialize($_COOKIE['cartGoods']):[];

			$_k = $input['gid'].'-'.$input['gaid'];

			$cartGoods[$_k]++;

			setcookie('cartGoods',serialize($cartGoods), time()+86400,'/');
		}
		}elseif($input['type']=='reduce'){
			//如果会员已经登陆,就修改数据库中的数量,点击一次就数量+1
			if($member_id){
				$res = DB::table('cart')
						->where('goods_id', '=', $input['gid'])
						->where('goods_attr_ids', '=', $input['gaid'])
						->decrement('goods_number',1);
				if(!$res){
					return array(
							'status' => 0,
							'error'  => '修改购物车失败'
					);
				}

			}else{
				//操作cookie
				$cartGoods = isset($_COOKIE['cartGoods'])?unserialize($_COOKIE['cartGoods']):[];

				$_k = $input['gid'].'-'.$input['gaid'];

				$cartGoods[$_k]--;

				setcookie('cartGoods',serialize($cartGoods), time()+86400,'/');
			}
		}
	}

	public function ajaxGetGoods(Cart $cart){
		$data = $cart->get_cart_data();
		return \json_encode($data['cartList']);
	}

	//生成订单
	public function order(Request $request){
	   	$input = $request->except('_token');

		$buythis = isset($input['buythis'])?$input['buythis']:'';

		if($buythis==''){
			$buythis = session('buythis');

			if($buythis==''){
			  return back()->withErrors('至少要选择一件商品才能下单')->withInput();
			}
		}else{
			session(['buythis'=>$buythis]);
		}

		$member_id = session('member_id');

		if(!$member_id){
			$url = route('cartOrder');

			session(['returnUrl' => $url]);

			return redirect('/login');
		}

		//添加订单,先展示订单页面
		$cartData = (new Cart())->get_cart_data();

		//取出选中的商品

		$res = [];

		foreach($cartData['cartList'] as $k=>$v){
			if(in_array($v['goods_id'].'-'.$v['goods_attr_ids'], $buythis)){
            $res[] = $v;
			}
		}
		$cartList = $res;

        $total_price = 0;

		$total_goods_number = 0;

		foreach($cartList as $v){

		$total_price+=$v['singlePri'];

		$total_goods_number+=$v['goods_number'];

		}

		$data = $this->set_page_info('订单页面', '京西', '京西', '0', ['fillin'], ['cart2']);


		return view('home.cart.order')->with(['data'=>$data, 'cartList'=>$cartList, 'total_price'=>$total_price, 'total_goods_number'=>$total_goods_number]);

	}
}
