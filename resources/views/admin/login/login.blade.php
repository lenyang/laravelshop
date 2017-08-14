<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{asset('/resources/assets/admin/Styles/general.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/resources/assets/admin/Styles/main.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('/resources/assets/admin/Styles/parsley.css')}}">
    <script type="text/javascript" src="{{asset('/resources/assets/admin/Js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('/resources/assets/admin/Js/parsley.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/resources/assets/admin/Styles/font/css/font-awesome.min.css')}}">
</head>
<body style="background: #278296;color:white">
@include('errors.errors')
<form method="post" action="" onsubmit="return validate()" data-parsley-validate>
    {{csrf_field()}}
    <table cellspacing="0" cellpadding="0" style="margin-top:100px" align="center">
        <tr>
            <td>
                <img src="{{asset('resources/assets/admin/Images/login.png')}}" width="178" height="256" border="0" alt="ECSHOP" />
            </td>
            <td style="padding-left: 50px">
                <table>
                    <tr>
                        <td>管理员姓名：</td>
                        <td>
                            <input type="text" name="username" data-parsley-trigger="blur" required data-parsley-required-message="请输入用户名!"/>
                        </td>
                    </tr>
                    <tr>
                        <td>管理员密码：</td>
                        <td>
                            <input type="password" name="password" data-parsley-trigger="blur" required data-parsley-required-message="请输入密码!"/>
                        </td>
                    </tr>
                    <tr>
                        <td>验证码：</td>
                        <td>
                            <input type="text" class="code" name="code" data-trigger="blur" required  data-parsley-required-message="请输入验证码!"/><br />
                            <img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <img src="" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="checkbox" if($){} value="1" name="remember" id="remember" />
                            <label for="remember">请保存我这次的登录信息。</label>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" value="进入管理中心" class="button" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
  <input type="hidden" name="act" value="signin" />
</form>
</body>