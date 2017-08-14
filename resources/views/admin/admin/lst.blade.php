@extends('layouts.admin')

@section('content')


    <table class="table table-hover">
        <thead>
        <tr>
            <th>编号</th>
            <th>用户名</th>
            <th>是否启用</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($admins as $admin)
        <tr>
            <td>{{ $admin->id }}</td>
            <td>{{ $admin->username }}</td>
            <td admin_id="{{ $admin->id }}" onclick="changeIsUse(this)">
                @if($admin->is_use==0)
                    {{ '禁用' }}
                    @elseif($admin->is_use==1)
                    {{ '启用' }}
                @endif
            </td>
            <td>
                <a href="{{ url('admin/admin/'.$admin->id.'/edit') }}">编辑</a>
                @if($admin->id!=1)
                |<a href="javascript:;" admin_id="{{ $admin->id }}" onclick="delAdmin(this)">删除</a>
                @endif
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <script>
        function delAdmin(o){
            var admin_id = $(o).attr('admin_id');

            layer.confirm('您确定要删除这个角色吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{ url('admin/admin/') }}/'+admin_id ,{'_method':'delete','_token':'{{ csrf_token() }}'},function(data){
                    if(data.status==1){
                        layer.msg(data.msg, {icon: 6});
                        $(o).parent().parent().remove();
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            })
        }

        function changeIsUse(o){
            var admin_id = $(o).attr('admin_id');
            if(admin_id==1){
                alert('不能修改超级管理员的启用状态!');
                return false;
            }
            $.post('{{ url("admin/changeuse") }}',{'_token':'{{ csrf_token() }}','admin_id':admin_id}, function(data){

                if(data.status==1){

            $(o).html(data.msg);
            }
            });
        }

    </script>
@endsection