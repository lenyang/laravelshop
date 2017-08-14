<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin;
use App\Http\Model\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Admin $admin, Request $request)
    {
//        $uri=$request->path();
//        dd($uri);
        //取出所有的管理员
        $admins = $admin->get();

        return view('admin.admin.lst')->with(['page_btn_link'=>"/admin/admin/create",'page_btn_name'=>'添加管理员','page_btn_title'=>'管理员列表', 'admins'=>$admins]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //取出所有的角色
        $roles = (new Role)->get_all_roles();

        return view('admin.admin.add')->with(['page_btn_link'=>"/admin/admin",'page_btn_name'=>'管理员列表','page_btn_title'=>'添加管理员', 'roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Admin $admin)
    {
        //
        $input = $request->except('_token');
        $rules = [
            'role_id'  => 'required',
            'username' => 'required|unique:admin',
            'password' => 'required|confirmed|between:4,6',
            'password_confirmation' =>'required',
            'is_use'   => 'required'
        ];

        $message = [
            'role_id.required' => '必须选择一个角色',
            'username.required' => '用户名不能为空',
            'unique'   => '用户名必须唯一',
            'password.required' => '密码不能为空',
            'confirmed' => '两次输入的密码不一致',
            'password_confirmation.required' => '确认密码不能为空',
            'is_use.required' => '必须选择是否启用',
        ];

        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {
           return back()->withErrors($validator)->withInput();
        }

        //将密码md5加密

        $input['password'] = md5($input['password']);

        $admin_id = DB::table('admin')->insertGetId(
            ['username'=>$input['username'], 'password'=>$input['password'], 'is_use'=>$input['is_use']]
        );

        //将管理员所属角色添加到管理员角色中间表
        $roleIds = $input['role_id'];

        $res = $admin->add_admin_role($admin_id, $roleIds);

        if ($res) {
          return redirect('admin/admin');
        }else{
            return back()->withErrors('添加管理员失败!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role,$admin)
    {

        //查看当前登陆用户是否有权限修改
        if(session('user')->id!=$admin->id && session('user')->id!=1){
            return back()->with('msg', '无权修改!');
        }

        //取出所有的角色
        $roles = $role->get_all_roles();

        //取出该管理员所属的全部角色

        $roleIds = $admin->get_admin_roles($admin->id);

        $ids = '';

        foreach($roleIds as $v){
            $ids .=$v->role_id.',';
        }

        $roleIds = rtrim($ids,',');

        return view('admin.admin.edit')->with(['page_btn_link'=>"/admin/admin",'page_btn_name'=>'管理员列表','page_btn_title'=>'添加管理员', 'roles'=>$roles, 'roleIds'=>$roleIds, 'admin'=>$admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $admin)
    {
        $input = $request->except('_token','_method');

        $rules = [
            'role_id'  => 'required',
            'username' => 'required',
            'password' => 'confirmed|between:4,6',
            'is_use'   => 'required'
        ];

        $message = [
            'role_id.required' => '必须选择一个角色',
            'username.required' => '用户名不能为空',
            'confirmed' => '两次输入的密码不一致',
            'is_use.required' => '必须选择是否启用',
        ];

        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        //判断用户是否有修改密码
        if(empty($input['password'])){
            $admin->username = $input['username'];
            $admin->is_use = $input['is_use'];
            $admin->save();
            //删除原来的角色信息
            $admin->del_admin_roles($admin->id);
            //加入新的角色信息
            $res = $admin->add_admin_role($admin->id, $input['role_id']);
            if($res){
              return redirect('admin/admin')->withErrors('修改信息成功');
            }else{
                return back()->withErrors('修改管理员失败');
            }
        }else{
            $input['password'] = md5($input['password']);
            $admin->username = $input['username'];
            $admin->is_use = $input['is_use'];
            $admin->password = $input['password'];
            $admin->save();
            //删除原来的角色信息
            $admin->del_admin_roles($admin->id);
            //加入新的角色信息
            $res = $admin->add_admin_role($admin->id, $input['role_id']);
            if($res){
                return redirect('admin/admin')->withErrors('修改信息成功');
            }else{
                return back()->withErrors('修改管理员失败');
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($admin)
    {
        //删除管理员所对应的角色
        $admin->del_admin_roles($admin->id);

        //从角色表中将其删除
        $res = $admin->delete();

        if($res == 1){
            $data = [
                'status' => '1',
                'msg' => '成功删除'
            ];
        }else{
            $data = [
                'status' => '0',
                'msg' => '删除失败'
            ];
        }
        return $data;
    }

    /**
     * 修改管理员的启用状态
     */
    public function changeIsUse(Request $request){
        $admin_id = $request->admin_id;

        //取出该id对应的启用状态
        $is_use_status = DB::table('admin')->where('id', '=', $admin_id)->select('is_use')->get();

        if($is_use_status[0]->is_use==1){
            $res = DB::table('admin')->where('id', '=', $admin_id)->update(['is_use'=>0]);
            if($res){
              return array(
                  'status' => '1',
                  'msg' => '禁用'
              );
            }else{
                return array(
                    'status' => '0'
                );
            }
        }elseif($is_use_status[0]->is_use==0){
            $res = DB::table('admin')->where('id', '=', $admin_id)->update(['is_use'=>1]);
            if($res){
                return array(
                    'status' => '1',
                    'msg' => '启用'
                );
            }else{
                return array(
                    'status' => '0'
                );
            }

        }

    }
}
