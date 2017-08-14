@extends('layouts.admin')

@section('content')

    <table class="table table-condensed table-hover">
        <thead>
        <th>分类名称</th>
        <th>操作</th>
        </thead>
        <tbody>

        @foreach($categorys as $category)
            <tr>
                <td>{{ str_repeat('----',$category->level).$category->cat_name }}</td>
                <td>
                    <a href="{{ url('admin/category/'.$category->id.'/edit') }}">编辑</a> |
                    <a href="javascript:;" onclick="delPri({{$category->id}})">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
<script>

</script>