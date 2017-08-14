@extends('layouts.admin')

@section('content')

    <div class="main-div">
        @include('errors.errors')
        <form name="main_form" method="POST" action="{{ url('admin/admin/'.$admin->id) }}" data-parsley-validate>
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td align="right">角色名称：</td>
                    <td>
                        @foreach($roles as $role)
                        <input
                                @if(strpos(','.$roleIds.',',','.$role->id.',')!==false)
                                        {{ 'checked="checked"' }}
                                        @endif
                                type="checkbox" name="role_id[]" value="{{ $role->id }}" />{{ $role->role_name }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td align="right">用户名：</td>
                    <td>
                       <input type="text" name="username" value="{{ $admin->username }}" data-parsley-trigger="blur" required data-parsley-required-message="请输入用户名!">
                    </td>
                </tr>
                <tr>
                    <td align="right">密码：</td>
                    <td>
                        <input type="password" name="password" >
                    </td>
                </tr>
                <tr>
                    <td align="right">确认密码：</td>
                    <td>
                        <input type="password" name="password_confirmation">
                    </td>
                </tr>
                <tr>
                    <td align="right">是否启用(1启用|0禁用)：</td>
                    <td>
                        <input type="radio"
                               @if($admin->is_use==0)
                                       {{ 'checked="checked"' }}
                                       @endif
                               name="is_use" value="0" >禁用&nbsp;&nbsp;&nbsp;<input type="radio" name="is_use" value="1"   @if($admin->is_use==1)
                            {{ 'checked="checked"' }}
                                @endif>启用
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





