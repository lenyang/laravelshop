@extends('layouts.home')
	
		@section('content')
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="{{asset('/resources/assets/home/images/logo.png')}}" alt="京西商城"></a></h2>
			<div class="flow fr">
				<ul>
					<li class="cur">1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->

	@include('errors.errors')
	<div style="clear:both;"></div>
	<form method="post" id="cart_form" action="{{ url('/cart/order') }}">
    {{ csrf_field() }}
	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col2">商品信息</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>

			@foreach($cartList as $k=>$v)
				<tr gaid="{{$v['goods_attr_ids']}}" gid="{{ $v['goods_id'] }}">
					<td class="col1"><input type="checkbox" name="buythis[]" value="{{ $v['goods_id'].'-'.$v['goods_attr_ids'] }}"><a href="{{ url('/goods/'.$v['goods_id']) }}">{{ showImage($v['sm_logo']) }}</a>  <strong><a href="">{{ $v['goods_name'] }}</a></strong></td>
					<td class="col2">@foreach($v['attr'] as $k1=>$v1) <p>{{ $v1[0]->attr_name }}：{{ $v1[0]->attr_value }}<span>[属性价格:{{ $v1[0]->attr_price }}]</span></p>@endforeach </td>
					<td class="col3">￥<span>{{ $v['price'] }}</span></td>
					<td class="col4"> 
						<a href="javascript:;" class="reduce_num" type="reduce"></a>
						<input type="text" name="amount" value="{{ $v['goods_number'] }}" class="amount"/>
						<a href="javascript:;" class="add_num" type="add"></a>
					</td>
					<td class="col5">￥<span>{{ $v['singlePri'] }}</span></td>
					<td class="col6"><a href="">删除</a></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total">{{ $total_price }}</span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="" class="continue">继续购物</a>
			<a href="#" class="checkout" onclick="$('#cart_form').submit()">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->
		</form>
<script>
	//ajax修改购物车中的商品
    $('.add_num').click(function(){
			var gaid = $(this).parent().parent().attr('gaid');
			var gid = $(this).parent().parent().attr('gid');
			var type = $(this).attr('type');
		var data = {
			gaid  : gaid,
			gid   : gid,
			_token: '{{ csrf_token() }}',
			type  : type
		};
		$.ajax({
			type:'post',
			data: data,
			url : "{{ url('/cart/ajaxUpdateGoods') }}",
			success:function(msg){
				if(msg.status==0){
					alert(msg.error);
				}
			}
		});

	});
</script>
	@endsection