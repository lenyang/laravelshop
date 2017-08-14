<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Type;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Type $type)
    {
        //取出所有的商品类型及每个类型的属性总量
        $type_data = $type->get_all_types();

        return view('admin.type.lst')->with(['page_btn_link'=>"/admin/type/create",'page_btn_name'=>'添加商品类型','page_btn_title'=>'商品类型列表','type_data'=>$type_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.type.add')->with(['page_btn_link'=>"/admin/type",'page_btn_name'=>'商品类型列表','page_btn_title'=>'添加商品类型']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Type $type)
    {
        //
        $input = $request->except('_token');

        $rules = [
            'type_name' => 'required|unique:type'
        ];

        $message = [
            'required' => '类型名称必须填写',
            'unique'   =>  '不能搞两个一样的类型'
        ];

        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {
         return back()->withErrors($validator)->withInput();
        }

        $type->type_name = $input['type_name'];

        $type->save();

        $id= $type->id;

        if($id){
           return redirect('admin/type');
        }else{
            return back()->withErrors('添加类型失败!');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxGetAttr(Request $request, Type $type){
        $input = $request->except('_token');

        $type_id = $input['type_id'];

        //取出对应的类型id

        $data  = DB::table('attribute as a')
            ->where('a.type_id', '=', $type_id)
            ->select('a.*')
            ->get();

        return json_encode($data);
    }
}
