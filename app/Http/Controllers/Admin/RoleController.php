<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Privilege;
use Illuminate\Http\Request;
use App\Http\Model\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role)
    {
        //

        $role_pri_data = $role->get_role_privilege();

        return view('admin.role.lst')->with(['page_btn_link'=>"/admin/role/create",'page_btn_name'=>'添加角色','page_btn_title'=>'角色列表', 'role_pri_data'=>$role_pri_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //取出所有的peivilege数据

        $privileges = (new Privilege)->getTree();

        return view('admin.role.add')->with(['page_btn_link'=>"/admin/role",'page_btn_name'=>'角色列表','page_btn_title'=>'添加角色', 'privileges'=>$privileges]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Role $role)
    {

        $input =  $request->except('_token');

        $role->role_name = $input['role_name'];

        $role->save();

        $id = $role->id;

        $role->add_role_privilege($id, $input['pri_id']);

        return redirect('admin/role');


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

        //取出这个角色所用的全部的权限id
        $priIds = $role->get_privilege_ids($role->id);

        $ids = '';

        foreach ($priIds as $k=>$v) {
            $ids .= ','.$v->pri_id;
        }

        $priIds = ltrim($ids,',');

        //取出所有的权限名称
        $privileges = (new Privilege)->getTree();

        return view('admin.role.edit')->with(['priIds'=>$priIds, 'role'=>$role, 'privileges'=>$privileges, 'page_btn_link'=>"/admin/role",'page_btn_name'=>'角色列表','page_btn_title'=>'编辑角色']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        //将原来中间表的角色对应的权限删掉

        $role->del_privileges($role->id);
        //dd(lastSql());
        //将新得到的权限id插入角色权限表

        $priIds = $request->pri_id;

        $role->add_role_privilege($role->id, $priIds);

         return redirect('admin/role');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role)
    {
        //
        $role->del_privileges($role->id);

        //从角色表中将其删除
        $res = $role->delete();

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
}
