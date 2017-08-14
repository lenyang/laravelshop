@extends('layouts.admin')

@section('content')

@include('errors.errors')
    <form role="form" action="{{ url('admin/privilege') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">父级权限</label>
            <select class="form-control" name="parent_id">
                <option value="0">顶级权限</option>
                @foreach($priData as $k=>$v)
                <option value="{{ $v->id }}">{{ str_repeat('---',$v->level).$v->pri_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">权限名称</label>
            <input type="text" class="form-control" id="name" name="pri_name"
                   placeholder="请输入名称" size="10">
        </div>
            <div class="form-group">
                <label for="name">模块名称</label>
                <input type="text" class="form-control" id="name" name="module_name"
                       placeholder="请输入模型名称" size="10">
            </div>
            <div class="form-group">
                <label for="name">控制器名称</label>
                <input type="text" class="form-control" id="name" name="controller_name"
                       placeholder="请输入控制器名称" size="10">
            </div>
            <div class="form-group">
                <label for="name">方法名称</label>
                <input type="text" class="form-control" id="name" name="action_name"
                       placeholder="请输入方法名称" size="10">
            </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@endsection