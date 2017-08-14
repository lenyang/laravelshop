@extends('layouts.home')

@section('content')

	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="{{ url('/') }}"><img src="{{asset('/resources/assets/home/images/logo.png')}}" alt="京西商城"></a></h2>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		@include('errors.errors')

		<div class="login_bd">
			<div class="login_form fl">
				<form action="" method="post" data-parsley-validate>
					{{ csrf_field() }}
					<ul>
						<li>
							<label for="">用户名：</label>
							<input type="text" class="txt" name="email" data-parsley-required="true" data-parsley-trigger="blur" data-parsley-required-message="用户邮箱不可为空"/>
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" class="txt" name="password" data-parsley-required="true" data-parsley-trigger="blur" data-parsley-required-message="密码不可为空"/>
							<a href="">忘记密码?</a>
						</li>
						<li class="checkcode">
							<label for="">验证码：</label>
							<input type="text" data-parsley-required="true" data-parsley-trigger="blur" data-parsley-required-message="验证码不可为空" name="checkcode" />
							<img src="{{ url('/code') }}" onclick="this.src='{{ url('/code') }}?'+Math.random()" alt="" />
							<span>看不清？<a href="">换一张</a></span>
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" class="chb"  /> 保存登录信息
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="submit" value="" class="login_btn" />
						</li>
					</ul>
				</form>

				<div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href=""><span></span>QQ</a></dd>
						<dd class="weibo"><a href=""><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div>
			</div>
			
			<div class="guide fl">
				<h3>还不是商城用户</h3>
				<p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

				<a href="{{ url('/register') }}" class="reg_btn">免费注册 >></a>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

	@endsection