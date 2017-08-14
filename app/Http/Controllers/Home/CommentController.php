<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
header("content-type:text/html;charset=utf8");
class CommentController extends Controller
{
    //
	public function store(Request $request, Comment $comment){
		$data = $request->except('_token');
		$goods_id = $request->goods_id;
		$formData = explode('&', $data['formData']);
		$arr = [];
		foreach ($formData as $item) {
			$v = explode('=', $item);
			$arr[$v[0]] = $v[1];

		}
		$rules = [
			'star'      => 'required|numeric',
			'content'   => 'required',
			'imp_name'  => 'required'
		];

		$validator = Validator::make($arr, $rules);

		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}

		$arr['goods_id'] = $data['goods_id'];
        $arr['member_id'] = session('member_id');
		$arr['addtime'] = time();

		//印象入库
		$comment->add_impression($arr['imp_name'], $goods_id);

		//评论表数据入库
        $res = $comment->create($arr);


		if($res){
			echo \json_encode([
				'pic' => '',
				'status' => '1',
				'member_id' => session('member_id'),
				'content'   => $arr['content'],
				'star'      => $arr['star'],
				'addtime'   => date('Y-m-d H:i:s', $arr['addtime'])
			]);
		}else{
			return \json_encode(array(
				'status' => 0,
				'msg'    => '添加评论失败'
			));
		}


	}
}
