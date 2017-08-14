@extends('layouts.admin')
<style>
    .myButton {
        -moz-box-shadow:inset 0px 1px 0px 0px #d9fbbe;
        -webkit-box-shadow:inset 0px 1px 0px 0px #d9fbbe;
        box-shadow:inset 0px 1px 0px 0px #d9fbbe;
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #b8e356), color-stop(1, #a5cc52));
        background:-moz-linear-gradient(top, #b8e356 5%, #a5cc52 100%);
        background:-webkit-linear-gradient(top, #b8e356 5%, #a5cc52 100%);
        background:-o-linear-gradient(top, #b8e356 5%, #a5cc52 100%);
        background:-ms-linear-gradient(top, #b8e356 5%, #a5cc52 100%);
        background:linear-gradient(to bottom, #b8e356 5%, #a5cc52 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b8e356', endColorstr='#a5cc52',GradientType=0);
        background-color:#b8e356;
        -moz-border-radius:7px;
        -webkit-border-radius:7px;
        border-radius:7px;
        border:1px solid #83c41a;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:15px;
        font-weight:bold;
        padding:3px 10px;
        text-decoration:none;
        text-shadow:0px 1px 0px #86ae47;
    }
    .myButton:hover {
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #a5cc52), color-stop(1, #b8e356));
        background:-moz-linear-gradient(top, #a5cc52 5%, #b8e356 100%);
        background:-webkit-linear-gradient(top, #a5cc52 5%, #b8e356 100%);
        background:-o-linear-gradient(top, #a5cc52 5%, #b8e356 100%);
        background:-ms-linear-gradient(top, #a5cc52 5%, #b8e356 100%);
        background:linear-gradient(to bottom, #a5cc52 5%, #b8e356 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#a5cc52', endColorstr='#b8e356',GradientType=0);
        background-color:#a5cc52;
    }
    .myButton:active {
        position:relative;
        top:1px;
    }

</style>
@section('content')

    <div class="list-div" style="margin-bottom: 5px; margin-top: 10px;" id="listDiv">


        <form method="post" action="{{ url('admin/goodsnumber/store') }}" name="addForm" id="addForm">
            {{ csrf_field() }}
            <input type="hidden" name="goods_id" value="{{ $goods_id }}">

            <table width="100%" cellpadding="3" cellspacing="1" id="table_list">
                <tbody><tr>
                    <th colspan="20" scope="col"><span style="font-weight: bold">{{ $goods_name[0]->goods_name }}</span>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                </tr>
                <tr>
                    @foreach($storeData as $k=>$v)
                    <!-- start for specifications -->
                    <td scope="col" style="background-color: rgb(255, 255, 255);"><div align="center"><strong>{{ $v[0]->attr_name }}</strong></div></td>
                    <!-- end for specifications -->
                    @endforeach
                    <td class="label_2" style="background-color: rgb(255, 255, 255);">库存</td>
                    <td class="label_2" style="background-color: rgb(255, 255, 255);">&nbsp;</td>
                </tr>


                    @foreach($exist_goods_store as $k0=>$v0)
                        <tr>
                    @foreach($storeData as $k=>$v)
                            <!-- start for specifications_value -->
                    <td align="center" style="background-color: rgb(255, 255, 255);">
                        <select name="attr[]">
                            <option value="" selected="">请选择...</option>
                            @foreach($v as $k1=>$v1)
                                <option @if(strpos(','.$v0->goods_attr_ids.',',','.$v1->id.',')!==false){{'selected="selected"'}}@endif value="{{ $v1->id }}">{{ $v1->attr_value }}</option>
                            @endforeach
                        </select>
                    </td>
                    @endforeach
                    <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="goods_number[]" value="{{ $v0->goods_number }}" size="10"></td>
                    <td style="background-color: rgb(255, 255, 255);"><input type="button" goods_attr_id="{{$v0->goods_attr_ids}}" class="myButton" value=" - " onclick="removeGoodsStore(this)"></td>

                </tr>
                    @endforeach

                <tr id="attr_row">
                    @foreach($storeData as $k=>$v)
                    <!-- start for specifications_value -->
                    <td align="center" style="background-color: rgb(255, 255, 255);">
                        <select name="attr[]">
                            <option value="" selected="">请选择...</option>
                            @foreach($v as $k1=>$v1)
                            <option value="{{ $v1->id }}">{{ $v1->attr_value }}</option>
                                @endforeach
                        </select>
                    </td>
                    <!-- end for specifications_value -->
                    @endforeach
                    <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="goods_number[]" value="1" size="10"></td>
                    <td style="background-color: rgb(255, 255, 255);"><input type="button" class="myButton" value="+" onclick="add_attr_product(this);"></td>
                </tr>

                <tr>
                    <td align="center" colspan="4" style="background-color: rgb(255, 255, 255);">
                        <input type="submit" class="button" value=" 保存 " onclick="checkgood_sn()">
                    </td>
                </tr>
                </tbody></table>
        </form>


    </div>
    <script>
        function add_attr_product(o){
            var str = $(o).parent().parent();

            var new_str = str.clone();

            if($(o).val()=='+'){
              new_str.find('input').val('-');
                str.after(new_str);
            }else{
                str.remove();
            }
        }

        function removeGoodsStore(o){
            var goods_attr_id = $(o).attr('goods_attr_id');
            layer.confirm('您确定要删除该库存吗？', {
                btn: ['确定','取消'] //按钮
            }, function() {
                $.post("{{url('admin/goodsnumber/delete')}}", {'_token': '{{csrf_token()}}', 'goods_attr_id': goods_attr_id}, function (data) {
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