<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Privilege;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PrivilegeController extends IndexController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $privileges = Privilege::get();
        return view('admin.privilege.lst')->with(['page_btn_link'=>"/admin/privilege/create",'page_btn_name'=>'添加权限','page_btn_title'=>'权限列表', 'privileges'=>$privileges]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // 取出所有的权限数据
        $priData = (new Privilege)->getTree();
        //dd($priData);
        return view('admin.privilege.add')->with(['page_btn_link'=>"/admin/privilege",'page_btn_name'=>'权限列表','page_btn_title'=>'添加权限', 'priData'=>$priData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Privilege $privilege)
    {
        $input = $request->except('_token');
        //dd($input);
        $this->validate($request, [
            'pri_name' => 'required|unique:privilege',
            'parent_id' => 'required',
        ]);
        $res = $privilege->create($input);
        if($res){
        return redirect('admin/privilege');
        }else{
            return back()->withInput()->with('msg', '添加权限失败');
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
    public function edit($privilege)
    {
        $priData = (new Privilege)->getTree();
        return view('admin.privilege.edit')->with(['privilege'=>$privilege, 'priData'=>$priData, 'page_btn_link'=>"/admin/privilege/create",'page_btn_name'=>'添加权限','page_btn_title'=>'权限列表']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $privilege)
    {
        //
        $data = $request->except('_token', '_method');
        $this->validate($request, [
            'pri_name' => 'required',
            'parent_id' => 'required',
        ]);
        $res = $privilege->update($data);
        if($res){
            return redirect('admin/privilege')->with('msg', '更新成功');
        }else{
            return back()->withInput()->with('errors', '更新失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($privilege)
    {
        //

    }
}
