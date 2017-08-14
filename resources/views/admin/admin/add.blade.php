@extends('layouts.admin')

@section('content')

    <div class="main-div">
        @include('errors.errors')
        <form name="main_form" method="POST" action="{{ url('admin/admin') }}" data-parsley-validate>
            {{ csrf_field() }}
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td align="right">角色名称：</td>
                    <td>
                        @foreach($roles as $role)
                        <input type="checkbox" name="role_id[]" value="{{ $role->id }}" />{{ $role->role_name }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td align="right">用户名：</td>
                    <td>
                       <input type="text" name="username" data-parsley-trigger="blur" required data-parsley-required-message="请输入用户名!">
                    </td>
                </tr>
                <tr>
                    <td align="right">密码：</td>
                    <td>
                        <input type="password" name="password" data-parsley-trigger="blur" required data-parsley-required-message="请输入密码!">
                    </td>
                </tr>
                <tr>
                    <td align="right">确认密码：</td>
                    <td>
                        <input type="password" name="password_confirmation" data-parsley-trigger="blur" required data-parsley-required-message="请输入确认密码!">
                    </td>
                </tr>
                <tr>
                    <td align="right">是否启用(1启用|0禁用)：</td>
                    <td>
                        <input type="radio" name="is_use" value="0">禁用&nbsp;&nbsp;&nbsp;<input type="radio" name="is_use" value="1" checked="checked">启用
                    </td>
                </tr>
                <tr>
                    <td colspan="99" align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
        </form>
    </div>

@endsection





