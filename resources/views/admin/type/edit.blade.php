@extends('layouts.admin')

@section('content')

    <div class="main-div">
        <form name="main_form" method="POST" action="{{ url('admin/role/'.$role->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table cellspacing="1" cellpadding="3" width="100%">
                <tr>
                    <td class="label">角色名称：</td>
                    <td>
                        <input  type="text" name="role_name" value="{{ $role->role_name }}" />
                    </td>
                </tr>
                <tr>
                    <td class="label">权限列表：</td>
                    <td>
                        @foreach($privileges as $k => $v)
                            {{ str_repeat('-', 8*$v->level) }}
                            <input level_id="{{ $v->level }}"
                                   @if(strpos(','.$priIds.',',','.$v->id.',')!==false)
                                   {{ "checked='checked'" }}
                                   @endif
                                   type="checkbox" name="pri_id[]" value="{{ $v->id }}" />
                            {{ $v->pri_name }}<br />
                        @endforeach
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
    <script>
        $(':checkbox').click(function(){
            var level_id;
            var str = $(this).prop('checked');
            var tem_level_id = level_id = $(this).attr('level_id');
            if(str){
                $(this).nextAll(':checkbox').each(function(k, v){
                    if($(v).attr("level_id") > level_id){

                        $(v).prop("checked", "checked");
                    }else{
                        return false;
                    }
                });
                //选上上级权限
                $(this).prevAll(':checkbox').each(function(k, v){
                    if($(v).attr('level_id') < tem_level_id){
                        $(v).prop("checked", "checked");
                        tem_level_id--;
                    }
                })
            }else{
                $(this).nextAll(':checkbox').each(function(k, v){
                    if($(v).attr("level_id") > level_id){

                        $(v).prop("checked", "");
                    }else{
                        return false;
                    }
                });
            }

        });
    </script>
@endsection





