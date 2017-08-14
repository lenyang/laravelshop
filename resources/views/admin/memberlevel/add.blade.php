@extends('layouts.admin')

@section('content')

@include('errors.errors')
    <form role="form" action="{{ url('admin/memberlevel') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">会员级别名称</label>
            <input type="text" class="form-control" id="name" name="level_name"
                   placeholder="请输入名称" size="10">
        </div>
        <div class="form-group">
            <label for="name">积分下限</label>
            <input type="text" class="form-control" id="name" name="bottom_num"
                    size="10">
        </div>
        <div class="form-group">
            <label for="name">积分上限</label>
            <input type="text" class="form-control" id="name" name="top_num"
                   placeholder="请输入名称" size="10">
        </div>
        <div class="form-group">
            <label for="name">折扣率</label>
            <input type="text" class="form-control" id="name" name="rate"
                   size="10">
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@endsection