<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

require_once base_path().'/resources/org/code/Code.class.php';
class LoginController extends Controller
{
    //
	public function login(){
		if($input = Input::all()){
			$rules = [
				'username' => 'required',
				'password' => 'required',
				'code'     =>  'required'
			];
			$message = [
				'requied'  => '这个:attribute必须填写',
			];
			$validator = Validator::make($input, $rules, $message);
			if($validator->fails()){
				return back()->withInput()->withErrors($validator);
			}
			$code = new \Code();
			$_code = $code->get();
			if(strtoupper($input['code'])!=$_code){
				return back()->withErrors('验证码不正确');
			}
			//判断用户名和密码是否正确
			$admin = Admin::where('username', $input['username'])->first();

			if(($admin->password)!=md5($input['password'])){
				return back()->withInput()->withErrors('用户名或密码不正确!');
			}
			session(['user' => $admin]);

			return redirect('admin/index');
		}
		return view('admin.login.login');
	}
	public function code(){
		$code = new \Code;
		return $code->make();
	}
	//用户推出
	public function logout(){
		//清除登陆session
		session(['user'=>null]);
		return redirect('admin/login');
	}
}
