@extends('layouts.admin')

@section('content')

    <div class="main-div">
        @include('errors.errors')
        <form name="main_form" method="POST" action="{{ url('admin/type') }}" data-parsley-validate>
            {{ csrf_field() }}
            <table cellspacing="1"  cellpadding="3" width="100%">
                <tr>
                    <td align="right" width="50%">类型名称：</td>
                    <td align="left" width="50%">
                        <input  type="text" name="type_name" value="" data-parsley-trigger="blur" required data-parsley-required-message="请输入类型名称!"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" class="button" value=" 确定 " />
                        <input type="reset" class="button" value=" 重置 " />
                    </td>
                </tr>
            </table>
        </form>
    </div>

@endsection





