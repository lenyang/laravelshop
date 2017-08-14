@extends('layouts.admin')

@section('content')

    @include('errors.errors')
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front">基本信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="{{ url('admin/goods') }}" method="post">
            {{ csrf_field() }}
            <table width="90%" class="table_content" align="center">
                    <td align="right">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td align="right">商品分类：</td>
                    <td>
                        <select name="cat_id">
                            <option value="0">请选择...</option>
                            @foreach($catData as $v)
                            <option value="{{ $v->id }}">{{ str_repeat('----',$v->level).$v->cat_name }}</option>
                            @endforeach
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td align="right">商品图片：</td>
                    <td>
                        <input type="file" name="logo" size="35" /><br />
                    </td>
                </tr>
                <tr>
                    <td align="right">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="1"/> 是
                        <input type="radio" name="is_on_sale" value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <input type="checkbox" value="1" name="is_promote"
                       onclick="if($(this).prop('checked')){$('.promote_price').removeAttr('disabled');}else{$('.promote_price').attr('disabled','disabled');}"/>
                        促销价：</td>
                    <td>
                        <input type="text" disabled="disabled" class="promote_price" name="promote_price">
                    </td>
                </tr>
                <tr>
                    <td align="right">促销日期：</td>
                    <td>
                        <input disabled="disabled" class="promote_price" type="text" id="st" name="promote_start_time"/>-<input disabled="disabled" class="promote_price" type="text" id="end" name="promote_end_time" checked="checked"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="is_best" value="1" /> 精品
                        <input type="checkbox" name="is_new" value="1" /> 新品
                        <input type="checkbox" name="is_hot" value="1" /> 热销
                    </td>
                </tr>
                <tr>
                    <td align="right">推荐排序：</td>
                    <td>
                        <input type="text" name="sort_num" size="5" value="100"/>
                    </td>
                </tr>
              </table>
            <!-- 简单描述 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr>
                    <td align="right">商品简单描述：</td><br />
                    <td>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="goods_desc" data-parsley-trigger="blur" required data-parsley-required-message="请填写文章内容" type="text/plain" style="width:860px;height:500px;"></script>
                        <script type="text/javascript">
                            var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style><br />
                    </td>
                </tr>
                </table>
            <!-- 会员价格 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                @foreach($memData as $v)
                <tr>
                    <td align="right">{{ $v->level_name }}({{ $v->rate }})：</td>
                    <td>
                        <input type="text" name="level_price[]" value="-1">
                    </td>
                </tr>
                @endforeach
                <tr><td colspan="2" align="center" style="color:grey">会员价格为-1时表示会员价格按会员等级折扣率计算。你也可以为每个等级指定一个固定价格</td></td></tr>
                </table>
            <!-- 商品属性 -->
            <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none;">
                <tr>
                    <td align="right">商品属性：</td>
                    <td>
                        <select name="type_id" onchange="ajax_get_attrbute(this)">
                            <option value="0">请选择</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2" id="tbody-goodsAttr" style="padding:0" align="center"></td></tr>
                </table>

            <!-- 商品相册 -->
            <table class="table_content"  cellspacing="1" cellpadding="8" width="100%" style="display:none;">
                <tr>
                    <td align="right" width="30%">商品相册：</td>
                <td >
                    <a href="javascript:;" onclick="addImg(this)">[+]</a>上传文件 <input name="imgs[]" type="file">
                </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>
<script>
    $('#tabbar-div p span').click(function(){
        var i =$(this).index();

        //隐藏所有的table
        $('.table_content').hide();

        $('.table_content').eq(i).show();

        $('.tab-front').removeClass('tab-front').addClass('tab-back');

        //其他的加上另外一个样式
        $(this).removeClass('tab-back').addClass('tab-front');
    });
    //添加时间插件
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
    $("#st").datepicker({ dateFormat: "yy-mm-dd" });
    $("#end").datepicker({ dateFormat: "yy-mm-dd" });

    //ajax获取类型的属性
    function ajax_get_attrbute(o){
        var type_id = $(o).val();
        if(type_id>0){
            var data = {
                _token:'{{csrf_token()}}',
                type_id:type_id
            };
            $.ajax({
                type:'post',
                dataType: 'json',
                data: data,
                url : '{{ url('admin/ajaxGetAttr') }}',
                success:function(msg){
                    html = "<table width='100%' cellspacing='4'><tbody>";
                    $(msg).each(function(k,v){
                        if(v.attr_type==1){
                          html+="<tr><td align='right'><a href='javascript:void()' onclick='addnew(this)'>[+]</a>";
                        }else{
                            html += "<tr><td align='right'>";
                        }
                    html+=v.attr_name+"</td>&nbsp;&nbsp;";
                        if(v.attr_value==''){
                            html+="<td><input type='text' name='ga["+ v.id+"][]'></td>";
                        }else{
                            var _attr = v.attr_value.split(',');
                            html+="<td><select name='ga["+ v.id+"][]'><option value=''>请选择</option>";
                            for (var i=0;i<_attr.length;i++) {
                                html+="<option value='"+_attr[i]+"'>"+_attr[i]+"</option>";
                            }
                            html+="</select>";

                            if(v.attr_type==1){
                              html+="属性价格<input type='text' name='price["+ v.id+"][]'>";
                            }
                            html+="</td>";
                        }

                    html+= "</tr>";
                    });
                    html += "</tbody></table>";

                    $('#tbody-goodsAttr').html(html);
                }
            });

        }
    }

    /**
     *
     * @param o
     */
    function addnew(o){
        var str = $(o).parent().parent();

        var new_str = str.clone();

        if($(o).html()=='[+]'){
            new_str.find('a').html('[-]');
            str.after(new_str);
        }else if($(o).html()=='[-]'){
           str.remove();
        }
    }

    /**
     *
     * @param o
     */
    function addImg(o){
        var str = $(o).parent().parent();

        var new_str = str.clone();

        if($(o).html()=='[+]'){
            new_str.find('a').html('[-]');
            str.after(new_str);
        }else if($(o).html()=='[-]'){
            str.remove();
        }
    }
</script>

@endsection