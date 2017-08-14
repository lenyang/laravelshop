<?php

	/**
	 * @param $to
	 * @param $title
	 * @param $content
	 *
	 * @return bool
	 * @throws phpmailerException
	 */
	function sendMail($to, $title, $content)
	{
		require_once('./PHPMailer_v5.1/class.phpmailer.php');
		$mail = new PHPMailer();
		// 设置为要发邮件
		$mail->IsSMTP();
		// 是否允许发送HTML代码做为邮件的内容
		$mail->IsHTML(TRUE);
		// 是否需要身份验证
		$mail->SMTPAuth=TRUE;
		$mail->CharSet='UTF-8';
		/*  邮件服务器上的账号是什么 */
		$mail->From='你的邮箱账号';
		$mail->FromName='azhuwc0914	';
		$mail->Host='smtp.163.com';
		$mail->Username='你的邮箱账号';
		$mail->Password='你的邮箱密码';//这里不是邮箱的登陆密码,而是你的邮箱的授权码,具体的网上搜索
		// 发邮件端口号默认25
		$mail->Port = 25;
		// 收件人
		$mail->AddAddress($to);
		// 邮件标题
		$mail->Subject=$title;
		// 邮件内容
		$mail->Body=$content;
		return($mail->Send());
	}

	/**
	 * @param $file
	 * @param $dirName
	 * @param array $thumb
	 *
	 * @return mixed
	 */
	function uploadOne($file, $dirName, $thumb=array()){

		if ($file->isValid()) {

		 $res['ok'] = 1;

		 $entension = $file->getClientOriginalExtension(); //上传文件的后缀.

		 $newName = date('YmdHis') . mt_rand(100, 999) . '.' . $entension; //新的文件名

		 $res['images'][0] = $dirName.$newName;
		 if($thumb){
			 foreach($thumb as $k=>$v){
				 $res['images'][$k+1] = $dirName.'thumb_' .$k.'_'. $newName;
				 Image::make($file)->resize($v[0], $v[1])->save($res['images'][$k+1]);
			 }
		 }
		 $path = $file->move(base_path() .'/'. $dirName, $newName);
		 chmod($path, 0777);

	  }else{
		$res['ok'] = 0;
	 }
	return $res;

	}

	/**
	 * @return mixed
	 */
	function lastSql(){

		$sql = DB::getQueryLog();

		$query = end($sql);

		return $query;

	}

	/**
	 * 根据表名中的数据制作select下拉框
	 *
	 * @param $tableName,$valueField,$selectName,$nameField,$selectedId
	 *
	 * @return string
	 */

	function bulidSelect($tableName, $valueField, $selectName, $nameField, $selectedValue=''){

		$data = \Illuminate\Support\Facades\DB::table($tableName)
			->select($valueField, $nameField)
			->get();

		$select = "<select name='".$selectName."'>";

		$select .= "<option value=''>请选择</option>";

		foreach ($data as $v) {
			if(!empty($selectedValue)){
				if($v->$valueField == $selectedValue){
					$selected = "selected='selected";
				}else{
					$selected = '';
				}
			}

			$select .= "<option ".$selected." value='".$v->$valueField."'>".$v->$nameField."</option>";
		}

		$select .= "</select>";

		echo $select;
}

	/**
	 * @param $url
	 * @param string $width
	 * @param string $height
	 */
	function showImage($url, $width='', $height=''){
	if($width){
	$width = "width='".$width."'";
	}
	if($height){
		$height = "height='".$height."'";
	}
	echo '<img '.$width.$height.' src="http://www.php32.com/'.$url.'" />';
    }

	function deleteImage($url){
		chmod('./'.$url, 0777);
		unlink('./'.$url);
	}

	function makeAlipayBtn($orderId){
		return require('./alipay/alipayapi.php');
	}
