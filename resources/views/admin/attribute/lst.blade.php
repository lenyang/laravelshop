@extends('layouts.admin')

@section('content')

    <p>
        <img src="{{ asset('/resources/assets/admin/Images/icon_search.gif') }}" width="26" height="22" border="0" alt="SEARCH">

        按商品类型显示：
        <select name="goods_type" onchange=" location.href='{{ url('admin/attribute/') }}/'+$(this).val()">
            <option value="0">所有商品类型</option>
            @foreach($type_data as $k1=>$v1)
                <option
                        @if($type_id == $v1->id)
                                {{ 'selected="selected"' }}
                                @endif
                        value="{{$v1->id}}">{{ $v1->type_name }}</option>
            @endforeach
        </select>
    </p>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>编号</th>
            <th>属性名</th>
            <th>商品类型</th>
            <th>属性类型</th>
            <th>可选值列表</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attributes as $attribute)
        <tr>
            <td>{{ $attribute->id }}</td>
            <td>{{ $attribute->attr_name }}</td>
            <td>{{ $attribute->type_name }}</td>
            <td><?php echo $attribute->attr_type==1?'可选':'唯一';?></td>
            <td>{{ $attribute->attr_value }}</td>

            <td>
                <a href="{{ url('attribute/attribute/'.$attribute->id.'/edit') }}">编辑</a>
                @if($attribute->id!=1)
                |<a href="javascript:;" attribute_id="{{ $attribute->id }}" onclick="delattribute(this)">删除</a>
                @endif
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <script>
        function delattribute(o){
            var attribute_id = $(o).attr('attribute_id');

            layer.confirm('您确定要删除这个角色吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{ url('attribute/attribute/') }}/'+attribute_id ,{'_method':'delete','_token':'{{ csrf_token() }}'},function(data){
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
            var attribute_id = $(o).attr('attribute_id');
            if(attribute_id==1){
                alert('不能修改超级管理员的启用状态!');
                return false;
            }
            $.post('{{ url("attribute/changeuse") }}',{'_token':'{{ csrf_token() }}','attribute_id':attribute_id}, function(data){

                if(data.status==1){

            $(o).html(data.msg);
            }
            });
        }

    </script>
@endsection