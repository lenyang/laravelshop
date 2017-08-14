<?php
namespace App\Http\Controllers\Home;


use App\Http\Model\Cart;
use App\Http\Model\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Home\HomeController;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MemberController extends HomeController{

	/**
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function register(){
		if($input=Input::all()){
			$rules = [
				'email'    => 'required|email|unique:member',
				'password' => 'required|confirmed',
			    'checkcode'=> 'required'
			];

			$message = [
				'required'           =>  ':attribute不能为空',
				'email'              =>  '输入的邮箱格式不正确',
				'password.confirmed' => '两次输入的密码不一致'
			];

			$validator = Validator::make($input, $rules, $message);

			if($validator->fails()){
				return back()->withErrors($validator);
			}

			//检验验证码是否正确
			$code = new \Code();

			$_code = $code->get();

			if(strtoupper($input['checkcode'])!=$_code){
				return back()->withErrors('验证码不正确');
			}


			//现将数据处理
			$input['password'] = md5($input['password']);

			$input['email_code'] = uniqid();

			$input['addtime'] = time();

			//入库,返回会员基本信息
			$member = (new Member())->create($input);
			$content =<<<HTML
		<p>欢迎您成为本站会员，请点击以下链接地址完成email验证。</p>
		<p><a href="http://www.php32.com/emailchk/uid/{$member->id}/code/{$member->email_code}">点击完成验证</a></p>
HTML;
			//发送验证邮箱
            //这里用的是Mail包,用框架自带的也是可以的,大家尝试一下就好,网上有教程的
			$result = sendMail($member->email, '验证', $content);

			if($member){
				return redirect('/login');
			}else{
				return back()->with('msg', '注册失败');
			}
		}
		//设置页面信息
		$data = $this->set_page_info('注册','京西','京西','1',['login']);
		return view('home.member.regist')->with([
			'data'   =>  $data
		]);
	}


	/**
	 * generate captcha
	 */
	public function code(){
		$code = new \Code;
		return $code->make();
	}

	public function login(Member $member,Request $request){
		if($input = Input::all()){

			$rules = [
				'email'        => 'required|email',
				'password'     => 'required',
				'checkcode'    => 'required'
			];

			$message = [
					'required'           =>  ':attribute不能为空',
					'email'              =>  '输入的邮箱格式不正确'
			];

			$validator = Validator::make($input, $rules, $message);

			if($validator->fails()){
				return back()->withErrors($validator);
			}

			//检验验证码是否正确
			$code = new \Code();

			$_code = $code->get();

			if(strtoupper($input['checkcode'])!=$_code){
				return back()->withErrors('验证码不正确');
			}


			//查找用户信息
			$user_info = $member->get_user_info($input['email']);

			if($user_info){
				//判断邮箱是否已经通过验证
				$res = $member->check_email_status($user_info->id);

				if(!empty($res[0])){
					return back()->withErrors('您的邮箱尚未通过验证,请先验证再登陆')->withInput();
				}
				//和数据库中的密码进行验证

				if($user_info->password=md5($input['password'])){
					//将会员存入session
					session(['member'=> $user_info->email]);
					//将会员id存到session中
					session(['member_id'=> $user_info->id]);
					//根据用户id取出对应的会员级别id
					$member_level_info = $member->get_user_level($user_info->jifen);

					//存放对应的会员级别
					session(['member_level_id'=> $member_level_info[0]->id]);
					//存放对应的折扣率
					session(['member_level_rate'=> $member_level_info[0]->rate]);

					//如果购物车中的cookie中有数据的话,将其转存到数据库中

					(new Cart())->moveCookieToDb();

					//判断是由哪个页面跳转到登陆页面的

					$previous_url = session('returnUrl');

					if(isset($previous_url)){

                    $request->session()->forget('returnUrl');

					return redirect($previous_url);

					}else{
						return redirect('/');
					}
				}else{
					return back()->withErrors('用户名或密码无效');
				}
			}else{
				return back()->withErrors('用户名或密码无效');
			}
		}
		//设置页面信息
		$data = $this->set_page_info('登陆','京西','京西','1',['login']);

		return view('home.member.login')->with(['data' =>$data]);
	}


	public function emailchk(Request $request){
      //取出数据库中的email_code
		$code = $request->code;
		$uid = $request->uid;
		$email_code = DB::table('member')
				->where('id', '=', $uid)
				->lists('email_code');
		if($email_code[0] == $code){
			//通过验证,将数据库中的email_code清空
			DB::table('member')
					->where('id', '=', $uid)
					->update([
						'email_code' => ''
					]);
			return redirect('/login')->with('msg','邮箱验证成功');
		}else{
			return back()->withErrors('邮箱验证失败');
		}
	}

	public function logout(Request $request){
		$request->session()->forget('member');

		$request->session()->forget('member_id');

		$request->session()->forget('member_level_id');

		$request->session()->forget('member_level_rate');

		return redirect('/login')->withMsg('成功退出!');
	}

	public function saveAndLogin(){
		$url = $_SERVER['HTTP_REFERER'];
		session(['returnUrl'=>$url]);
	}

	public function getMemberPrice($id, Member $member){
       $data = $member->get_member_price($id);
		echo $data;
	}
}