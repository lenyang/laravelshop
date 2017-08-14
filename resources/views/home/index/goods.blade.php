@extends('layouts.home')

@section('header')
@parent
@include('layouts.header')
@endsection

@section('content')
	<!-- jqzoom 效果 -->
	<script type="text/javascript">
		$(function(){
			$('.jqzoom').jqzoom({
	            zoomType: 'standard',
	            lens:true,
	            preloadImages: false,
	            alwaysOn:false,
	            title:false,
	            zoomWidth:400,
	            zoomHeight:400
	        });
		})
	</script>

  @include('errors.errors')
	<!-- 商品页面主体 start -->
	<div class="main w1210 mt10 bc">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2>当前位置：<a href="">首页</a> > <a href="">电脑、办公</a> > <a href="">笔记本</a> > ThinkPad X230(23063T4）12.5英寸笔记本</h2>
		</div>
		<!-- 面包屑导航 end -->
		
		<!-- 主体页面左侧内容 start -->
		<div class="goods_left fl">
			<!-- 相关分类 start -->
			<div class="related_cat leftbar mt10">
				<h2><strong>相关分类</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">笔记本</a></li>
						<li><a href="">超极本</a></li>
						<li><a href="">平板电脑</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关分类 end -->

			<!-- 相关品牌 start -->
			<div class="related_cat	leftbar mt10">
				<h2><strong>同类品牌</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">D-Link</a></li>
						<li><a href="">戴尔</a></li>
						<li><a href="">惠普</a></li>
						<li><a href="">苹果</a></li>
						<li><a href="">华硕</a></li>
						<li><a href="">宏基</a></li>
						<li><a href="">神舟</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关品牌 end -->

			<!-- 热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!-- 热销排行 end -->


			<!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
			<div class="related_view newgoods leftbar mt10">
				<h2><strong>浏览了该商品的用户还浏览了</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="images/relate_view1.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E431(62771A7) 14英寸笔记本电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="images/relate_view2.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="images/relate_view3.jpg" alt="" /></a></dt>
								<dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
								<dd><strong>￥7999.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="images/relate_view4.jpg" alt="" /></a></dt>
								<dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
								<dd><strong>￥6199.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="images/relate_view5.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
								<dd><strong>￥4399.00</strong></dd>
							</dl>
						</li>					
					</ul>
				</div>
			</div>
			<!-- 浏览过该商品的人还浏览了  end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap" id="recent_display">

				</div>
			</div>
			<!-- 最近浏览 end -->

		</div>
		<!-- 主体页面左侧内容 end -->
		
		<!-- 商品信息内容 start -->
		<div class="goods_content fl mt10 ml10">
			<!-- 商品概要信息 start -->
			<div class="summary">
				<h3><strong>{{ $goods_info->goods_name }}</strong></h3>
				
				<!-- 图片预览区域 start -->
				<div class="preview fl">
					<div class="midpic">
						<a href="{{asset('/'.$goods_info->logo)}}" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
							{{ showImage($goods_info->logo,350) }}               <!-- 第一幅图片的中图 -->
						</a>
					</div>
	
					<!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

					<div class="smallpic">
						<a href="javascript:;" id="backward" class="off"></a>
						<a href="javascript:;" id="forward" class="on"></a>
						<div class="smallpic_wrap">
							<ul>
								<li class="cur">
									<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '{{asset('/'.$goods_info->sm_logo)}}',largeimage: '{{asset('/'.$goods_info->logo)}}'}">{{ showImage($goods_info->sm_logo,350) }}</a>
								</li>
								@foreach($goods_pics as $k=>$v)
								<li >
									<a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '{{asset('/'.$v->sm_pic)}}',largeimage: '{{asset('/'.$v->pic)}}'}">{{ showImage($v->sm_pic) }}</a>
								</li>
								@endforeach

							</ul>
						</div>
						
					</div>
				</div>
				<!-- 图片预览区域 end -->

				<!-- 商品基本信息区域 start -->
				<div class="goodsinfo fl ml10">
					<ul>
						<li><span>商品编号： </span>{{ $goods_info->id }}</li>
						<li class="market_price"><span>定价：</span><em>￥{{ $goods_info->market_price }}</em></li>
						<li class="shop_price"><span>本店价：</span> <strong>￥{{ $goods_info->shop_price }}</strong> <a href="">(降价通知)</a></li>
						<li><span>上架时间：</span>{{ date('Y-m-d', $goods_info->addtime) }}</li>
						<li class="shop_price">会员价格：
							<p>
							<table border="1" cellpadding="5" cellspacing="5" width="30%">
								@foreach ($mpData as $k => $v)
								<tr>
									<td>{{  $v->level_name }}</td>
									<td>￥{{  $v->price }}元</td>
								</tr>
								@endforeach
							</table>
							</p>
						</li>
						<li class="shop_price">购买价格:<br /><span><strong style="font-size: 10px" id="member_price"></strong></span></li>
						<li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
					</ul>
					<form action="{{ url('/cart/store') }}" method="post" class="choose">
						{{ csrf_field() }}
						<ul>
							@foreach($attrs as $k=>$v)
							<li class="product">
								<dl>
									<dt>{{ $v[0]->attr_name }}：</dt>
									<dd>
										@foreach($v as $k1 => $v1)
										<a href="javascript:;">{{ $v1->attr_value }} <input type="radio" @if($k1==0){{ 'checked="checked"' }}@endif name="goods_attr_ids[{{$v1->id}}]" value="{{ $v1->attr_id }}"  /></a>
										@endforeach
										<input type="hidden" name="goods_id" value="{{ $goods_info->id }}" />
									</dd>
								</dl>
							</li>
							@endforeach
								<li>
									<dl>
										<dt>购买数量：</dt>
										<dd>
											<a href="javascript:;" id="reduce_num"></a>
											<input type="text" name="goods_number" value="1" class="amount"/>
											<a href="javascript:;" id="add_num"></a>
										</dd>
									</dl>
								</li>

								<li>
								<dl>
									<dt>&nbsp;</dt>
									<dd>
										<input type="submit" value="" class="add_btn" />
									</dd>
								</dl>
							</li>

						</ul>
					</form>
				</div>
				<!-- 商品基本信息区域 end -->
			</div>
			<!-- 商品概要信息 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品详情 start -->
			<div class="detail">
				<div class="detail_hd">
					<ul>
						<li class="first"><span>商品介绍</span></li>
						<li class="on"><span>商品评价</span></li>
						<li><span>售后保障</span></li>
					</ul>
				</div>
				<div class="detail_bd">
					<!-- 商品介绍 start -->
					<div class="introduce detail_div none">
						<div class="attr mt15">
							<ul>
								<li><span>商品名称：</span>{{ $goods_info->goods_name }}</li>
								<li><span>上架时间：</span>{{ date('Y-m-d H:i:s', $goods_info->addtime) }}</li>
								@foreach($goods_unique_attrs as $k=>$v)
								<li><span>{{ $v->attr_name }}：</span>{{ $v->attr_value }}</li>
								@endforeach
							</ul>
						</div>

						<div class="desc mt10">
							<!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
							<img src="images/desc1.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc2.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc3.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc4.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc5.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc6.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc7.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc8.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="images/desc9.jpg" alt="" />
						</div>
					</div>
					<!-- 商品介绍 end -->
					
					<!-- 商品评论 start -->
					<div class="comment detail_div mt10">
						<div class="comment_summary">
							<div class="rate fl">
								<strong><em>90</em>%</strong> <br />
								<span>好评度</span>
							</div>
							<div class="percent fl">
								<dl>
									<dt>好评（90%）</dt>
									<dd><div style="width:90px;"></div></dd>
								</dl>
								<dl>
									<dt>中评（5%）</dt>
									<dd><div style="width:5px;"></div></dd>
								</dl>
								<dl>
									<dt>差评（5%）</dt>
									<dd><div style="width:5px;" ></div></dd>
								</dl>
							</div>
							<div class="buyer fl">
								<dl>
									<dt>买家印象：</dt>
									<dd><span>屏幕大</span><em>(1953)</em></dd>
									<dd><span>外观漂亮</span><em>(786)</em></dd>
									<dd><span>系统流畅</span><em>(1091)</em></dd>
									<dd><span>功能齐全</span><em>(1109)</em></dd>
									<dd><span>反应快</span><em>(659)</em></dd>
									<dd><span>分辨率高</span><em>(824)</em></dd>
								</dl>
							</div>
						</div>

						<div id="comment_container">



						</div>
						<!-- 分页信息 start -->
						<div class="page mt20">
							<a href="">首页</a>
							<a href="">上一页</a>
							<a href="">1</a>
							<a href="">2</a>
							<a href="" class="cur">3</a>
							<a href="">4</a>
							<a href="">5</a>
							<a href="">下一页</a>
							<a href="">尾页</a>
						</div>
						<!-- 分页信息 end -->

						<!--  评论表单 start-->
						@if(NULL!=session('member'))
						<div class="comment_form mt20">
							<form action="" id="comment">
								<ul>
									<li>
										<label for=""> 评分：</label>
										<input type="radio" name="star" value="5"/> <strong class="star star5"></strong>
										<input type="radio" name="star" value="4"/> <strong class="star star4"></strong>
										<input type="radio" name="star" value="3" checked="checked"/> <strong class="star star3"></strong>
										<input type="radio" name="star" value="2"/> <strong class="star star2"></strong>
										<input type="radio" name="star" value="1"/> <strong class="star star1"></strong>
									</li>

									<li>
										<label for="">评价内容：</label>
										<textarea name="content" id="" cols="" rows=""></textarea>
									</li>
									<li>
										<label for="">用户印象：</label>
										<input type="text" name="imp_name" />
									</li>
									<li>
										<label for="">&nbsp;</label>
										<input type="button" value="提交评论"  onclick="ajaxSubmit()" class="comment_btn"/>
									</li>

								</ul>
							</form>
						</div>
					</div>
					@else
						<div class="comment_form mt20">
							<p><a href="javascript:" id="login_a">登录</a>	之后才可以评论!</p>
							</div>
					@endif
					<!--  评论表单 end-->
					<!-- 商品评论 end -->

					<!-- 售后保障 start -->
					<div class="after_sale mt15 none detail_div">
						<div>
							<p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
							<p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

						</div>

						<div>
							<h3>服务承诺：</h3>
							<p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p> 
							
							<p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

						</div>
						
						<div>
							<h3>权利声明：</h3>
							<p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
							<p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

						</div>
					</div>
					<!-- 售后保障 end -->

				</div>
			</div>
			<!-- 商品详情 end -->

			
		</div>
		<!-- 商品信息内容 end -->
		

	</div>
	<!-- 商品页面主体 end -->

<script>
	/*************记录最近浏览的商品************/
	//每进入一次商品详情页面就将id存放在cookie中
	var goods_id = '{!! $goods_info->id !!}';
	var data = {
		_token:'{{ csrf_token() }}',
		goods_id:goods_id
	};
	$.ajax({
		type:'post',
		data:data,
		dataType:'json',
		url:"{{ url('/index/displayHistory') }}",
		success:function(data){
         var html='';
			$(data).each(function(k, v){
				html+='<dl><dt><a href=""><img src="http://www.php32.com/'+ v.sm_logo+'" alt="" /></a></dt><dd><a href="{{url('/goods/')}}'+v.id+'">'+ v.goods_name+'</a></dd></dl>';
			});
			$('#recent_display').html(html);
		}
	});


	function ajaxSubmit(){
		var formData = $('#comment').serialize();
		formData = decodeURIComponent(formData,true);
		var goods_id = '{!! $goods_info->id !!}';
		var data = {
			formData:formData,
			_token: '{{ csrf_token() }}',
			goods_id:goods_id
		};
		$.ajax({
			type:'post',
			data:data,
			dataType:'json',
			url:"{{ url('/addcomment') }}",
			success:function(msg){
				if(msg.status==1){
					$('#comment').trigger("reset");
					var html='<div class="comment_items mt10"> <div class="user_pic"> <dl> <dt><a href=""><img src="'+msg.pic+'" alt="" /></a></dt> <dd><a href="">'+msg.username+'</a></dd> </dl> </div> <div class="item"> <div class="title"> <span>'+msg.addtime+'</span> <strong class="star star'+msg.star+'"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 --> </div> <div class="comment_content"> '+msg.content+'</div> <div class="btns"> <a href="" class="reply">回复(0)</a> <a href="" class="useful">有用(0)</a> </div> </div> <div class="cornor"></div> </div>';
                    html = $(html);
					$('#comment_container').prepend(html);
					//直接滚动到评论区的顶部
					$('body').animate({
						'scrollTop' : '470px'
					},1000,function(){
						html.fadeIn(3000);
					});
				}else{
					alert(msg.msg);
				}

			}
		});
	}
	//ajax实时取出登陆会员的价格
/**************点击登录时，先执行AJAX把当前地址存到SESSION********/
	$('#login_a').click(function(){
		$.ajax({
			type:'get',
			url:"{{  url('/savelogin')}}",
			success:function(msg){
				window.location.href="{{ url('/login') }}";
			}
		});
	});
/*************ajax取出会员价格***************/
	$.ajax({
	   type:'get',
		url:"{{ url('/getmemberprice/') }}/"+goods_id,
		success:function(msg){
			$('#member_price').html('RMB:'+msg);
		}
	});
</script>

<!--引入jueryui中的 文件-->
<link rel="stylesheet" href="{{asset('/resources/org/jqueryui/jquery-ui.min.css')}}" type="text/css">
<script type="text/javascript" src="{{asset('/resources/org/jqueryui/jquery-ui.min.js')}}"></script>


@endsection