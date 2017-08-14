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
        <form enctype="multipart/form-data" action="{{ url('admin/goods/'.$goods->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="90%" class="table_content" align="center">
                    <td align="right">商品名称：</td>
                    <td><input type="text" name="goods_name" value="{{ $goods->goods_name }}"size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td align="right">商品分类：</td>
                    <td>
                        <select name="cat_id">
                            <option value="0">请选择...</option>
                            @foreach($catData as $v)
                            <option @if($v->id==$goods->cat_id){{ 'selected="selected"' }}@endif value="{{ $v->id }}">{{ str_repeat('----',$v->level).$v->cat_name }}</option>
                            @endforeach
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td align="right">商品图片：</td>
                    <td>
                        <input type="file" name="logo" size="35" />
                        {{ showImage($goods->sm_logo) }}
                        <br />
                    </td>
                </tr>
                <tr>
                    <td align="right">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="{{ $goods->shop_price }}" size="20"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="{{ $goods->market_price }}" size="20"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" @if($goods->is_on_sale==1){{'checked="checked"'}}@endif value="1"/> 是
                        <input type="radio" name="is_on_sale" @if($goods->is_on_sale==0){{'checked="checked"'}}@endif value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <input type="checkbox" value="1" name="is_promote" @if($goods->is_promote==1){{'checked="checked"' }}@endif
                        onclick="if($(this).prop('checked')){$('.promote_price').removeAttr('disabled');}else{$('.promote_price').attr('disabled','disabled');}"/>
                        促销价：</td>
                    <td>
                        <input type="text" @if($goods->is_promote==0){{ 'disabled="disabled"' }}@endif class="promote_price" name="promote_price" value="{{ $goods->promote_price }}">
                    </td>
                </tr>
                <tr>
                    <td align="right">促销日期：</td>
                    <td>
                        <input @if($goods->promote_start_time>0) value="{{date('Y-m-d',$goods->promote_start_time)}}"@endif @if($goods->is_promote==0){{ 'disabled="disabled"' }}@endif class="promote_price" type="text" id="st" name="promote_start_time"/>-<input @if($goods->promote_end_time>0)value="{{date('Y-m-d',$goods->promote_end_time)}}"@endif class="promote_price" type="text" id="end" @if($goods->is_promote==0){{ 'disabled="disabled"' }}@endif name="promote_end_time" checked="checked"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" @if($goods->is_new==1){{'checked="checked"'}}@endif value="1"/> 是
                        <input type="radio" name="is_new" @if($goods->is_new==0){{'checked="checked"'}}@endif value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td align="right">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" @if($goods->is_best==1){{'checked="checked"'}}@endif value="1"/> 是
                        <input type="radio" name="is_on_sale" @if($goods->is_best==0){{'checked="checked"'}}@endif value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td align="right">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" @if($goods->is_hot==1){{'checked="checked"'}}@endif value="1"/> 是
                        <input type="radio" name="is_hot" @if($goods->is_hot==0){{'checked="checked"'}}@endif value="0"/> 否
                    </td>
                </tr>
                <tr>
                    <td align="right">推荐排序：</td>
                    <td>
                        <input type="text" name="sort_num" size="5" value="{{ $goods->sort_num }}"/>
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
                        <script id="editor" name="goods_desc" data-parsley-trigger="blur" required data-parsley-required-message="请填写文章内容" type="text/plain" style="width:860px;height:500px;">{!! $goods->goods_desc !!}</script>
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
                        <input type="text" name="level_price[{{$v->id}}]" value="{{$v->price}}">
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
                            <option @if($type->id==$goods->type_id){{ 'selected="selected"' }}@endif value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2" id="tbody-goodsAttr" style="padding:0" align="center">
                        {!! "<table width='100%' border='1' cellspacing='4'><tbody>" !!}
                          <?php $arr = array();?>
                        @foreach($goodsAttrs as $v)
                            @if(in_array($v->id, $arr))
                                <?php $opt='[-]';?>
                                @else
                                <?php $arr[]=$v->id;$opt='[+]';?>
                                @endif
                        @if(!empty($v->attr_value))
                            <?php $old='old_';?>
                                @else
                            <?php $old='';?>
                                @endif
                            @if($v->attr_type==1)
                           {!!  "<tr><td align='right'><a href='javascript:void()' onclick='addnew(this)'>".$opt."</a>" !!}
                                    @else
                                    {!!   "<tr><td align='right'>" !!}

                                    @endif
                                    {{ $v->attr_name}}
                                {!! "</td>&nbsp;&nbsp;" !!}
                                @if($v->value=='')
                               {!!  "<td><input type='text' value='".$v->attr_value."' name=".$old."ga[".$v->id."][".$v->attr_id."]></td>"!!}
                                @else
                                <?php $_attr = explode(',', $v->value);?>
                                {{--{{ $_attr = explode(',', $v->value) }}--}}

                                {!!  "<td width='5%'><select name=".$old."ga[".$v->id."][".$v->attr_id."]><option value=''>请选择</option>" !!}

                                    @foreach($_attr as $v1)
                                @if($v->attr_value==$v1)<?php $select = "selected='selected'";?>@else<?php $select='';?>@endif
                                <?php echo "<option ".$select." value='".$v1."'>".$v1."</option>"  ?>

                                        @endforeach
                                       {!!  "</select>"  !!}

                                    @if($v->attr_type==1)

                                    {!!   "<td>属性价格<input type='text' value='".$v->attr_price."' name=".$old."price[".$v->id."][".$v->attr_id."]></td>"!!}
                                    @endif
                                    {!!"</td>"!!}

                                @endif
                                {!!"</tr>" !!}
                                @endforeach
                            {!! "</tbody></table>"   !!}
                    </td></tr>
                </table>

            <!-- 商品相册 -->
            <table class="table_content"  cellspacing="1" cellpadding="8" width="100%" style="display:none;">
                <tr>
                    @foreach($pics as $v)
                    <td>
                        <a href="javascript:;" id="{{$v->id}}" onclick="if (confirm('您确实要删除该图片吗？')) dropImg(this)">[-]</a><br>
                        <a href="goods.php?act=show_image&amp;img_url=images/200905/goods_img/32_P_1242110760641.jpg" target="_blank">
                            {{ showImage($v->pic,90,90) }}
                        </a><br>
                    </td>
                        @endforeach
                </tr>
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
                            html+="<td><input type='text' name=ga["+ v.id+"][]'></td>";
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
            //将old_前缀弄掉
            var select_old_name = new_str.find("select").attr('name');

            var select_new_name = select_old_name.replace('old_','')

            new_str.find("select").attr('name', select_new_name);

            var input_old_name = new_str.find("input").attr('name');

            var input_new_name = input_old_name.replace('old_','')

            new_str.find("input").attr('name', input_new_name);

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

    function dropImg(o){
        var id = $(o).attr('id');

        $.post("{{url('admin/goods/ajaxDeleteImage')}}",{'_token':'{{csrf_token()}}','id':id},function(data){
            if(data.status==1){
                layer.msg(data.msg, {icon: 6});
                $(o).parent().remove();
            }else{
                layer.msg(data.msg, {icon: 5});
            }
        });
    }
</script>

@endsection