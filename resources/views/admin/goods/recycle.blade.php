@extends('layouts.admin')

@section('content')

     @include('errors.errors')
    <table class="table table-hover">
        <tbody><tr>
            <th>
                <input onclick="listTable.selectAll(this, &quot;checkboxes&quot;)" type="checkbox">
                <a title="点击对列表排序" href="# ">编号</a><?php showImage('resources/assets/admin/Images/sort_desc.gif')?></th>
            <th><a href="javascript:listTable.sort('goods_name'); ">商品名称</a></th>
            <th><a href="javascript:listTable.sort('shop_price'); ">价格</a></th>

            <th>操作</th>
        </tr><tr>
        </tr>
        @foreach($goods as $good)
        <tr>
            <td><input name="checkboxes[]" value="{{ $good->id }}" type="checkbox">{{ $good->id }}</td>
            <td class="first-cell" style=""><span onclick="listTable.edit(this, 'edit_goods_name', 32)">{{ $good->goods_name }}</span></td>
            <td align="left"><span onclick="listTable.edit(this, 'edit_goods_price', 32)">{{ $good->shop_price }}
    </span></td>
            <td align="left">
                <a href="{{ url('admin/goods/'.$good->id.'/restore') }}" title="还原">还原</a> |
                <a href="#" id="{{ $good->id }}" onclick="deleteGoods(this)">删除</a>
        </tr>
        @endforeach
        </tbody></table>
    <!-- end goods list -->

    <!-- 分页 -->
    <p>{!! $goods->links() !!}</p>

<script>
    function deleteGoods(o){
        var goods_id = $(o).attr('id');
        layer.confirm('您确定要删除该商品吗？', {
            btn: ['确定','取消'] //按钮
        }, function() {
            $.post("{{url('admin/goods')}}/"+goods_id, {'_token': '{{csrf_token()}}', '_method':'DELETE'}, function (data) {
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