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
            <th><a href="javascript:listTable.sort('is_on_sale'); ">上架</a></th>
            <th><a href="javascript:listTable.sort('is_best'); ">精品</a></th>
            <th><a href="javascript:listTable.sort('is_new'); ">新品</a></th>
            <th><a href="javascript:listTable.sort('is_hot'); ">热销</a></th>
            <th><a href="javascript:listTable.sort('sort_order'); ">推荐排序</a></th>
            <th>操作</th>
        </tr><tr>
        </tr>
        @foreach($goods as $good)
        <tr>
            <td><input name="checkboxes[]" value="{{ $good->id }}" type="checkbox">{{ $good->id }}</td>
            <td class="first-cell" style=""><span onclick="listTable.edit(this, 'edit_goods_name', 32)">{{ $good->goods_name }}</span></td>
            <td align="left"><span onclick="listTable.edit(this, 'edit_goods_price', 32)">{{ $good->shop_price }}
    </span></td>
            <td align="left"><img src="@if($good->is_on_sale==1){{ asset('/resources/assets/admin/Images/yes.gif') }}@else{{ asset('/resources/assets/admin/Images/no.gif') }}@endif" onclick="listTable.toggle(this, 'toggle_on_sale', 32)"></td>
            <td align="left"><img src="@if($good->is_best==1){{ asset('/resources/assets/admin/Images/yes.gif') }}@else{{ asset('/resources/assets/admin/Images/no.gif') }}@endif" onclick="listTable.toggle(this, 'toggle_best', 32)"></td>
            <td align="left"><img src="@if($good->is_new==1){{ asset('/resources/assets/admin/Images/yes.gif') }}@else{{ asset('/resources/assets/admin/Images/no.gif') }}@endif" onclick="listTable.toggle(this, 'toggle_new', 32)"></td>
            <td align="left"><img src="@if($good->is_hot==1){{ asset('/resources/assets/admin/Images/yes.gif') }}@else{{ asset('/resources/assets/admin/Images/no.gif') }}@endif" onclick="listTable.toggle(this, 'toggle_hot', 32)"></td>
            <td align="left"><span onclick="listTable.edit(this, 'edit_sort_order', 32)">{{ $good->sort_num }}</span></td>
            <td align="left">
                <a href="{{ url('admin/goods/'.$good->id.'/edit') }}" title="编辑"><img src="{{ asset('/resources/assets/admin/Images/icon_edit.gif') }}" height="16" border="0" width="16"></a>
                <a onclick="return confirm('确定要放入回收站!')" href="{{ url('admin/goods/'.$good->id.'/recycle') }}" onclick="listTable.remove(32, '您确实要把该商品放入回收站吗？')" title="回收站"><img src="{{ asset('/resources/assets/admin/Images/icon_trash.gif') }}" height="16" border="0" width="16"></a>
                <a href="{{ url('admin/goodsnumber/'.$good->id) }}" title="编辑"><img src="{{ asset('/resources/assets/admin/Images/icon_docs.gif')}}" width="16" height="16" border="0">
        </tr>
        @endforeach
        </tbody></table>
    <!-- end goods list -->

    <!-- 分页 -->

    <p>{!! $goods->links() !!}</p>


@endsection