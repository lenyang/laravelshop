<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<form method="POST" action="" enctype="multipart/form-data">
	{{csrf_field()}}
	商品名称:<input type="text" name="goods_name" /><br />
	商品价格:<input type="text" name="price" /><br />
	商品logo:<input type="file" name="logo[]" /><br />
	商品logo:<input type="file" name="logo[]" /><br />
	商品描述:
	<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
	<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
	<script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
	<script id="editor" name="goods_description" data-parsley-trigger="blur" required data-parsley-required-message="请填写文章内容" type="text/plain" style="width:860px;height:500px;"></script>
	<script type="text/javascript">
		var ue = UE.getEditor('editor');
	</script>
	<style>
		.edui-default{line-height: 28px;}
		div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
		{overflow: hidden; height:20px;}
		div.edui-box{overflow: hidden; height:22px;}
	</style><br />
	是否上架:
	<input type="radio" name="is_on_sale" value="1" checked="checked" />上架
	<input type="radio" name="is_on_sale" value="0" />下架
	<br />
	<input type="submit" value="提交" />
</form>
</body>
</html>