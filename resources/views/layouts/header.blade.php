<!-- 头部 start -->
<div class="header w1210 bc mt15">
    <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
    <div class="logo w1210">
        <h1 class="fl"><a href="index.html"><img src="{{asset('/resources/assets/home/images/logo.png')}}" alt="京西商城"></a></h1>
        <!-- 头部搜索 start -->
        <div class="search fl">
            <div class="search_form">
                @include('errors.errors')
                <div class="form_left fl"></div>
                <form action="" name="serarch" method="get" class="fl">
                    <input type="text" class="txt" name="key" id="key" value="{{ $key or '请输入商品关键字' }}" />
                    <input type="button" id="search_key" class="btn" value="搜索"/>
                </form>
                <div class="form_right fl"></div>
            </div>


            <div style="clear:both;"></div>

            <div class="hot_search">
                <strong>热门搜索:</strong>
                <a href="">D-Link无线路由</a>
                <a href="">休闲男鞋</a>
                <a href="">TCL空调</a>
                <a href="">耐克篮球鞋</a>
            </div>
        </div>
        <!-- 头部搜索 end -->

        <!-- 用户中心 start-->
        <div class="user fl">
            <dl>
                <dt>
                    <em></em>
                    <a href="">用户中心</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt">
                        您好，请<a href="">登录</a>
                    </div>
                    <div class="uclist mt10">
                        <ul class="list1 fl">
                            <li><a href="">用户信息></a></li>
                            <li><a href="">我的订单></a></li>
                            <li><a href="">收货地址></a></li>
                            <li><a href="">我的收藏></a></li>
                        </ul>

                        <ul class="fl">
                            <li><a href="">我的留言></a></li>
                            <li><a href="">我的红包></a></li>
                            <li><a href="">我的评论></a></li>
                            <li><a href="">资金管理></a></li>
                        </ul>

                    </div>
                    <div style="clear:both;"></div>
                    <div class="viewlist mt10">
                        <h3>最近浏览的商品：</h3>
                        <ul>
                            <li><a href=""><img src="{{asset('/resources/assets/home/images/view_list1.jpg')}}" alt="" /></a></li>
                            <li><a href=""><img src="{{asset('/resources/assets/home/images/view_list2.jpg')}}" alt="" /></a></li>
                            <li><a href=""><img src="{{asset('/resources/assets/home/images/view_list3.jpg')}}" alt="" /></a></li>
                        </ul>
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 用户中心 end-->

        <!-- 购物车 start -->
        <div class="user fl">
            <dl>
                <dt>
                    <a href="{{ url('/cart/index') }}">去购物车结算</a>
                    <b></b>
                </dt>
                <dd>
                    <div class="prompt" id="cart_div_list">
                        购物车中还没有商品，赶紧选购吧！
                    </div>
                </dd>
            </dl>
        </div>
        <!-- 购物车 end -->
    </div>
    <!-- 头部上半部分 end -->

    <div style="clear:both;"></div>

    <!-- 导航条部分 start -->
    <div class="nav w1210 bc mt10">
        <!--  商品分类部分 start-->
        <div class="category fl @if($data['show_nav']==0){{ 'cat1' }}@endif"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd @if($data['show_nav']==0){{ 'off' }}@endif">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd">
                @foreach($navData as $k=>$v)
                        <div class="cat @if($k==0){{ 'item1' }}@endif">
                            <h3><a href="{{ url('/list/'.$v->id) }}">{{ $v->cat_name }}</a> <b></b></h3>
                            <div class="cat_detail">
                                @foreach($v->sub as $k1=>$v1)
                                        <dl class="dl_1st">
                                            <dt><a href="{{ url('/list/'.$v1->id) }}">{{ $v1->cat_name }}</a></dt>
                                            <dd>
                                                @foreach($v1->children as $k2=>$v2)
                                                        <a href="{{ url('/list/'.$v2->id) }}">{{ $v2->cat_name }}</a>
                                                @endforeach
                                            </dd>
                                        </dl>
                                @endforeach


                            </div>
                        </div>
                @endforeach
                <div class="cat">
                    <h3><a href="">家用电器</a><b></b></h3>
                    <div class="cat_detail">
                        <dl class="dl_1st">
                            <dt><a href="">大家电</a></dt>
                            <dd>
                                <a href="">平板电视</a>
                                <a href="">空调</a>
                                <a href="">冰箱</a>
                                <a href="">洗衣机</a>
                                <a href="">热水器</a>
                                <a href="">DVD</a>
                                <a href="">烟机/灶具</a>
                            </dd>
                        </dl>

                        <dl>
                            <dt><a href="">生活电器</a></dt>
                            <dd>
                                <a href="">取暖器</a>
                                <a href="">加湿器</a>
                                <a href="">净化器</a>
                                <a href="">饮水机</a>
                                <a href="">净水设备</a>
                                <a href="">吸尘器</a>
                                <a href="">电风扇</a>
                            </dd>
                        </dl>

                        <dl>
                            <dt><a href="">厨房电器</a></dt>
                            <dd>
                                <a href="">电饭煲</a>
                                <a href="">豆浆机</a>
                                <a href="">面包机</a>
                                <a href="">咖啡机</a>
                                <a href="">微波炉</a>
                                <a href="">电磁炉</a>
                                <a href="">电水壶</a>
                            </dd>
                        </dl>

                        <dl>
                            <dt><a href="">个护健康</a></dt>
                            <dd>
                                <a href="">剃须刀</a>
                                <a href="">电吹风</a>
                                <a href="">按摩器</a>
                                <a href="">足浴盆</a>
                                <a href="">血压计</a>
                                <a href="">体温计</a>
                                <a href="">血糖仪</a>
                            </dd>
                        </dl>

                        <dl>
                            <dt><a href="">五金家装</a></dt>
                            <dd>
                                <a href="">灯具</a>
                                <a href="">LED灯</a>
                                <a href="">水槽</a>
                                <a href="">龙头</a>
                                <a href="">门铃</a>
                                <a href="">电器开关</a>
                                <a href="">插座</a>
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="cat">
                    <h3><a href="">手机、数码</a><b></b></h3>
                    <div class="cat_detail none">

                    </div>
                </div>

                <div class="cat">
                    <h3><a href="">电脑、办公</a><b></b></h3>
                    <div class="cat_detail none">

                    </div>
                </div>

                <div class="cat">
                    <h3><a href="">家局、家具、家装、厨具</a><b></b></h3>
                    <div class="cat_detail none">

                    </div>
                </div>

            </div>

        </div>
        <!--  商品分类部分 end-->

        <div class="navitems fl">
            <ul class="fl">
                <li class="current"><a href="">首页</a></li>
                @foreach($navData as $v)
                    @if($v->parent_id == 0)
                        <li><a href="">{{ $v->cat_name }}</a></li>
                    @endif
                @endforeach
            </ul>
            <div class="right_corner fl"></div>
        </div>
    </div>
    <!-- 导航条部分 end -->
</div>
<!-- 头部 end-->

<div style="clear:both;"></div>
<script>
    $('#cart_div_list').mouseover(function(){
        $.ajax({
            type:'get',
            dataType:'json',
            url: "{{ url('/cart/ajaxGetGoods') }}",
            success:function(msg){
               var html = '<div class="fl"><table>';
                $(msg).each(function(k,v){
                    html+= '<tr>';
                    html+= '<td><img width="30" src="/'+v.sm_logo+'"></td>';
                    html+= '<td>'+v.goods_name+'</td>'
                    html+= '</tr>';
                });
                html+= '</table></div>';
                $('#cart_div_list').html(html);
            }
        });


    });

    $('#search_key').click(function(){
        var key = $('#key').val();
        location.href = "{{ url('/list/key/') }}/"+key;
    });
</script>