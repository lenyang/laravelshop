@extends('layouts.admin')

@section('content')

    <table class="table table-condensed table-hover">
        <thead>
        <th>编号</th>
        <th>权限名称</th>
        <th>模块名称</th>
        <th>控制器名称</th>
        <th>方法名称</th>
        <th>操作</th>
        </thead>
        <tbody>
        @foreach($privileges as $privilege)
            <tr>
                <td>{{ $privilege->id }}</td>
                <td>{{ $privilege->pri_name }}</td>
                <td>{{ $privilege->module_name }}</td>
                <td>{{ $privilege->controller_name }}</td>
                <td>{{ $privilege->action_name }}</td>
                <td>
                    <a href="{{ url('admin/privilege/'.$privilege->id.'/edit') }}">编辑</a> |
                    <a href="javascript:;" onclick="delPri({{$privilege->id}})">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
<script>
    function delPri($pri_id){

    }
</script>