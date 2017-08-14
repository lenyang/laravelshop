@extends('layouts.admin')

@section('content')

    <table class="table table-condensed table-hover">
        <thead>
        <th>编号</th>
        <th>角色名称</th>
        <th>权限名称</th>
        <th>操作</th>
        </thead>
        <tbody>
        @foreach($role_pri_data as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ $v->role_name }}</td>
                <td>{{ $v->pri_name }}</td>
                <td>
                    <a href="{{ url('admin/role/'.$v->id.'/edit') }}">编辑</a> |
                    <a href="javascript:;" pri_id="{{$v->id}}" onclick="delPri(this)">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        function delPri(o){
            var pri_id = $(o).attr('pri_id');

         layer.confirm('您确定要删除这个角色吗？', {
             btn: ['确定','取消'] //按钮
         }, function(){
             $.post('{{ url('admin/role/') }}/'+pri_id ,{'_method':'delete','_token':'{{ csrf_token() }}'},function(data){
               if(data.status==1){
                   layer.msg(data.msg, {icon: 6});
                   $(o).parent().parent().remove();
               }else{
                   layer.msg(data.msg, {icon: 5});
               }
             });
         })
        }
    </script>
@endsection
