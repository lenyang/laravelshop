<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Attribute;
use App\Http\Model\Type;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{

	/**
	 * @return $attributes
	 */

	public function index(Attribute $attribute,$type_id){


		//取出所有的商品类型及每个类型的属性总量
		$type_data = (new Type)->get_all_types();

		//取出所有的属性值及其所对应的类型名
		$attributes = $attribute->get_all_attributes($type_id);

		return view('admin.attribute.lst')->with(['page_btn_link'=>"/admin/attribute/create/".$type_id,'page_btn_name'=>'添加属性','page_btn_title'=>'属性列表','attributes'=>$attributes, 'type_data'=>$type_data, 'type_id'=>$type_id]);
	}

	public function create($type_id){
		//获取所有的商品类型
		$types = Type::all();

		return view('admin.attribute.add')->with(['page_btn_link'=>"/admin/attribute/".$type_id,'page_btn_name'=>'商品属性','page_btn_title'=>'添加属性','types'=>$types, 'type_id'=>$type_id]);
	}

	/**
	 * 属性值入库
	 */

	public function store(Request $request,Attribute $attribute){
		$input = $request->except('_token');

		$rules = [
			'type_id'   => 'required',
			'attr_name' => 'required|unique:attribute',
			'attr_type' => 'required'
		];

		$message = [
			'required' => '这个:attribute不能为空',
			'unique'   => '不能搞两个一样的属性名'
		];

		$validator = Validator::make($input, $rules, $message);

		if($validator->fails()){
			return back()->withErrors($validator)->withInput();
		}

		$res = Attribute::create($input);

		if($res){
		return redirect('admin/attribute')->withMsg('添加属性成功');
		}else{
		return back()->withErrors('添加属性失败')->withInput();
		}
	}
}
