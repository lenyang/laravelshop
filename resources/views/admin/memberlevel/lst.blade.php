@extends('layouts.admin')

@section('content')

    <table class="table table-condensed table-hover">
        <thead>
        <th>会员级别名称</th>
        <th>积分下限</th>
        <th>积分上限</th>
        <th>折扣率</th>
        <th>操作</th>
        </thead>
        <tbody>

        @foreach($memberlevels as $memberlevel)
            <tr>
                <td>{{ $memberlevel->level_name }}</td>
                <td>{{ $memberlevel->bottom_num }}</td>
                <td>{{ $memberlevel->top_num }}</td>
                <td>{{ $memberlevel->rate }}</td>

                <td>
                    <a href="{{ url('admin/memberlevel/'.$memberlevel->id.'/edit') }}">编辑</a> |
                    <a href="javascript:;" onclick="delPri({{$memberlevel->id}})">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
<script>

</script>