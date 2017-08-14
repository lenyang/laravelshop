<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeController as BaseController;
use App\Http\Model\Order;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    //
	public function store(Request $request, Order $order){


		$input = $request->except('_token');

		$rules = [
			'shr_name'     		=> 'required|between:1,30',
			'shr_province' 		=> 'required',
			'shr_city'     		=> 'required',
			'shr_area'     		=> 'required',
			'shr_address'  		=> 'required',
			'shr_tel'      		=> 'required|digits:11|mobile',
            'shipping_method'   => 'required',
		    'pay_method'        => 'required'
		];

		$message = [
			'required' 			=> '这个:attribute不能为空',
			'shr_tel.mobile'    => '收货人电话格式不对!'
		];

//		$validator = Validator::make($input, $rules, $message);
//
//
//
//		if($validator->fails()) {
//
//			return back()->withErrors($validator)->withInput();
//		}



		$buythis = session('buythis');


		$status = $order->before_add_to_order($buythis, $request);


		if($status['error']=='no'){
			//开始下单,开启事物
			$input = array_merge($input, $status['input']);

			DB::beginTransaction();

			$res = $order->create($input);

			if(!$res){

				DB::rollBack();
			}

			//开始往商品订单表中添加数据

			$order->add_goods_order($buythis,$res->id, $request);

			$message = '<strong style="color: red;font-size: 40px">下单成功</strong>';

			$data = $this->set_page_info('订单成功', '京西', '京西', '0', ['success']);

			$btn = makeAlipayBtn($res->id);

			return view('home.order.success')->with(['msg' => $message, 'data'=>$data, 'btn'=>$btn]);
		}else{
			return redirect('/cart/index')->withErrors($status['error']);
		}

	}

	public function receive(){
		require('./alipay/notify_url.php');
	}
}

