@extends('layouts.admin')

@section('content')
    <p>
        <img src="{{ asset('/resources/assets/admin/Images/icon_search.gif') }}" width="26" height="22" border="0" alt="SEARCH">

        按商品类型显示：
        <select name="goods_type" onchange=" location.href='{{ url('admin/attribute/val/') }}/'+$(this).val()">
            <option value="0">所有商品类型</option>
            @foreach($type_data as $k1=>$v1)
                <option value="{{$v1->id}}">{{ $v1->type_name }}</option>
            @endforeach
        </select>
    </p>
    <table class="table table-condensed table-hover">
        <thead>
        <th>商品类型名称</th>
        <th>属性数</th>
        <th>操作</th>
        </thead>
        <tbody>
        @foreach($type_data as $v)
            <tr>
                <td>{{ $v->type_name }}</td>
                <td>{{ $v->attr_num }}</td>
                <td>
                    <a href="{{ url('admin/attribute/'.$v->id) }}">属性列表</a> |
                    <a href="{{ url('admin/type/'.$v->id.'/edit') }}">编辑</a> |
                    <a href="javascript:;" type_id="{{$v->id}}" onclick="delPri(this)">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <script>
        function delType(o){
            var type_id = $(o).attr('type_id');

         layer.confirm('您确定要删除这个类型吗？', {
             btn: ['确定','取消'] //按钮
         }, function(){
             $.post('{{ url('admin/type/') }}/'+type_id ,{'_method':'delete','_token':'{{ csrf_token() }}'},function(data){
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
