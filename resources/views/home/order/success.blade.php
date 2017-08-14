@extends('layouts.home')

		@section('content')
	<!-- 页面头部 start -->
<style>
	#alipaysubmit {margin: 10px auto;
		width:150px;}
	#alipaysubmit input{background: #F00; color: red;font-weight: bold;font-size: 20px;
		border:0;}
</style>
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="{{ asset('/resources/assets/home/images/logo.png') }}" alt="京西商城"></a></h2>
			<div class="flow fr flow3">
				<ul>
					<li>1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li class="cur">3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="success w990 bc mt15">
		<div class="success_hd">
			<h2>订单提交成功</h2>
			{!! $btn !!}
		</div>
		<div class="success_bd">
			<p><span></span>订单提交成功，我们将及时为您处理</p>
			
			<p class="message">完成支付后，你可以 <a href="">查看订单状态</a>  <a href="">继续购物</a> <a href="">问题反馈</a></p>
		</div>
	</div>
	<!-- 主体部分 end -->

	@endsection