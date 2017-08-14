@extends('layouts.admin')

@section('content')

@include('errors.errors')
    <form role="form" action="{{ url('admin/privilege/'.$privilege->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="name">父级权限</label>

            <select class="form-control" name="parent_id">
                <option value="0">顶级权限</option>
                @foreach($priData as $k=>$v)
                <option
                    <?php if($v->id == $privilege['parent_id']){
                        echo "selected='selected'";
                    }
                    ?>
                        value="{{ $v->id }}">{{ str_repeat('---',$v->level).$v->pri_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">权限名称</label>
            <input type="text" class="form-control" id="name" name="pri_name"
                   placeholder="请输入名称" value="{{ $privilege->pri_name }}">
        </div>
            <div class="form-group">
                <label for="name">模块名称</label>
                <input type="text" class="form-control" id="name" name="module_name"
                       placeholder="请输入模型名称" value="{{ $privilege->module_name }}">
            </div>
            <div class="form-group">
                <label for="name">控制器名称</label>
                <input type="text" class="form-control" id="name" name="controller_name"
                       placeholder="请输入控制器名称" value="{{ $privilege->controller_name }}">
            </div>
            <div class="form-group">
                <label for="name">方法名称</label>
                <input type="text" class="form-control" id="name" name="action_name"
                       placeholder="请输入方法名称" value="{{ $privilege->action_name }}">
            </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@endsection