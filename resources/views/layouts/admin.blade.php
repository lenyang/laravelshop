<!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心</title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('/public/backstage/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{asset('/resources/org/datetimepicker/jquery-ui-1.9.2.custom.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/public/backstage/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('/resources/org/datetimepicker/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('/resources/org/datetimepicker/datepicker-zh_cn.js')}}"></script>
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('/resources/org/datetimepicker/time/jquery-ui-timepicker-addon.min.css')}}" />
    <script type="text/javascript" src="{{asset('/resources/org/datetimepicker/time/jquery-ui-timepicker-addon.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/resources/org/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/resources/assets/admin/Styles/parsley.css')}}">
    <link href="{{asset('/resources/assets/admin/Styles/general.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/resources/assets/admin/Styles/main.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{asset('resources/org/layer/layer.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/resources/assets/admin/Styles/font/css/font-awesome.min.css')}}">
    <script src="{{ asset('/public/backstage/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $page_btn_link?>"><?php echo $page_btn_name?></a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $page_btn_title?> </span>
    <div style="clear:both"></div>
</h1>
@yield('content')
<div id="footer">
    共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>