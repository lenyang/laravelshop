@extends('layouts.admin')

@section('content')
    @include('errors.errors')
    <div class="main-div">
        <form action="{{url('admin/attribute')}}"  method="post" name="theForm" onsubmit="return validate();">
            {{ csrf_field() }}
            <table width="100%" id="general-table">
                <tr>
                    <td >属性名称：</td>
                    <td>
                        <input type='text' name='attr_name' value="" size='30' />
                        <span class="require-field">*</span>        </td>
                </tr>
                <tr>
                    <td >所属商品类型：</td>
                    <td>
                        <select name="type_id" onchange="onChangeGoodsType(this.value)">
                            <option value="0">请选择...</option>
                            @foreach($types as $type)
                                <option
                                        @if($type_id==$type->id)
                                         {{ 'selected="selected"' }}
                                        @endif
                                        value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td ><a href="javascript:showNotice('noticeAttrType');" title="点击此处查看提示信息"><img src="images/notice.gif" width="16" height="16" border="0" alt="点击此处查看提示信息"></a>属性是否可选</td>
                    <td>
                        <input  type="radio" name="attr_type" value="0"   checked="checked"/> 唯一属性          <input  type="radio"  name="attr_type" value="1"  /> 可选                    <br /><span class="notice-span" style="display:block"  id="noticeAttrType">选择"可选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。</span>
                    </td>
                </tr>
                <tr>
                    <td >可选值列表：</td>
                    <td>
                        <textarea id="attr_values" name="attr_value" cols="30" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="button-div">
                            <input type="submit" value=" 确定 " class="button"/>
                            <input type="reset" value=" 重置 " class="button" />
                        </div>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="act" value="insert" />
            <input type="hidden" name="attr_id" value="0" />
        </form>
    </div>
    <script>
        function type_status(o){
            var str = $(o).prop('checked');
            if(str){
               if($(o).val()==0){
                 $('#attr_values').attr('disabled',true);
               } else{
                   $('#attr_values').removeAttr('disabled');
               }
            }
        }
    </script>
@endsection