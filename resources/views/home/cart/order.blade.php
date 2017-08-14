@extends('layouts.home')
	@section('content')
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="{{ asset('/resources/assets/home/images/logo.png') }}" alt="京西商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	@include('errors.errors')
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息 <a href="javascript:;" id="address_modify">[修改]</a></h3>
				<div class="address_info">
					<p>王超平  13555555555 </p>
					<p>北京 昌平区 西三旗 建材城西路金燕龙办公楼一层 </p>
				</div>

				<div class="address_select none">
					<ul>
						<li class="cur">
							<input type="radio" name="address" checked="checked" />王超平 北京市 昌平区 建材城西路金燕龙办公楼一层 13555555555 
							<a href="">设为默认地址</a>
							<a href="">编辑</a>
							<a href="">删除</a>
						</li>
						<li>
							<input type="radio" name="address"  />王超平 湖北省 武汉市  武昌 关山光谷软件园1号201 13333333333
							<a href="">设为默认地址</a>
							<a href="">编辑</a>
							<a href="">删除</a>
						</li>
						<li><input type="radio" name="address" class="new_address"  />使用新地址</li>
					</ul>	
					<form action="{{ url('order/store') }}" class="none" name="address_form" method="post">
						{{ csrf_field() }}
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="shr_name" class="txt" />
							</li>
							<li>
								<label for=""><span>*</span>所在地区：</label>
								<select name="shr_province" id="">
									<option value="">请选择</option>
									<option value="北京">北京</option>
									<option value="上海">上海</option>
									<option value="天津">天津</option>
									<option value="重庆">重庆</option>
									<option value="武汉">武汉</option>
								</select>

								<select name="shr_city" id="">
									<option value="">请选择</option>
									<option value="朝阳区">朝阳区</option>
									<option value="东城区">东城区</option>
									<option value="西城区">西城区</option>
									<option value="海淀区">海淀区</option>
									<option value="昌平区">昌平区</option>
								</select>

								<select name="shr_area" id="">
									<option value="">请选择</option>
									<option value="西二旗">西二旗</option>
									<option value="西三旗">西三旗</option>
									<option value="三环以内">三环以内</option>
								</select>
							</li>
							<li>
								<label for=""><span>*</span>详细地址：</label>
								<input type="text" name="shr_address" class="txt address"  />
							</li>
							<li>
								<label for=""><span>*</span>手机号码：</label>
								<input type="text" name="shr_tel" class="txt" />
							</li>
						</ul>

					<a href="" class="confirm_btn"><span>保存收货人信息</span></a>
				</div>
			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>
				<div class="delivery_info">
					<p>普通快递送货上门</p>
					<p>送货时间不限</p>
				</div>

				<div class="delivery_select none">
					<table>
						<thead>
							<tr>
								<th class="col1">送货方式</th>
							</tr>
						</thead>
						<tbody>
							<tr class="cur">	
								<td>
									<input type="radio" checked="checked" name="shipping_method" checked="checked" value="顺丰"/>顺丰
								</td>
								<td>￥10.00</td>
								<td>每张订单不满499.00元,运费15.00元, 订单4...</td>
							</tr>
						</tbody>
					</table>
					<a href="" class="confirm_btn"><span>确认送货方式</span></a>
				</div>
			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->


				<div class="pay_select">
					<table> 
						<tr class="cur">
							<td class="col1"><input type="radio" name="pay_method" value="支付宝" checked="checked"/>支付宝</td>
							<td class="col2">送货上门后再收款，支持现金、POS机刷卡、支票支付</td>
						</tr>
					</table>
					<a href="" class="confirm_btn"><span>确认支付方式</span></a>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col2">规格</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
					@foreach($cartList as $k=>$v)
						<tr>
							<td class="col1"><a href="">{{ showImage($v['sm_logo']) }}</a>  <strong><a href="">{{ $v['goods_name'] }}</a></strong></td>
							<td class="col2">@foreach($v['attr'] as $k1=>$v1) <p>{{ $v1[0]->attr_name }}:{{ $v1[0]->attr_value }}[{{ $v1[0]->attr_price }}]</p>@endforeach </td>
							<td class="col3">{{ $v['xiaoji'] }}</td>
							<td class="col4"> {{ $v['goods_number'] }}</td>
							<td class="col5"><span>{{ $v['singlePri'] }}</span></td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span>{{ $total_goods_number }} 件商品，总商品金额：</span>
										<em>￥{{ $total_price }}</em>
									</li>

									<li>
										<span>应付总额：</span>
										<em>￥{{ $total_price }}</em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="#" onclick="$('form[name=address_form]').submit()"><span>提交订单</span></a>
			<p>应付总额：<strong>￥{{ $total_price }}元</strong></p>
			
		</div>
	</div>
	<!-- 主体部分 end -->
</form>
@endsection