@extends('layouts.admin')

@section('content')

@include('errors.errors')
    <form role="form" action="{{ url('admin/category') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">上级分类</label>
            <select class="form-control" name="parent_id">
                <option value="0">顶级分类</option>
                @foreach($catData as $k=>$v)
                <option value="{{ $v->id }}">{{ str_repeat('---',$v->level).$v->cat_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">分类名称</label>
            <input type="text" class="form-control" id="name" name="cat_name"
                   placeholder="请输入名称" size="10">
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@endsection