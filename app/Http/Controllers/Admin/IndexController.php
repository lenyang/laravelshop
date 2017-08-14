<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //

	public function index(){
		return view('admin.index');
	}
	public function top(){
		return view('admin.top');
	}
	public function main(){
		return view('admin.main');
	}
	public function menu(){
		//取出当前管理员所拥有的全部权限
		$admin_id= session('user')->id;
		//如果是超级管理员就取出全部的权限
		if ($admin_id==1) {
		$pri_data = DB::table('privilege')->get();
		}else{
			$pri_data = DB::table('admin_role as a')->select(DB::raw('distinct php32_c.*'))
					->leftJoin('role_privilege as b', 'a.role_id', '=', 'b.role_id')
					->leftJoin('privilege as c', 'b.pri_id', '=', 'c.id')
					->where('a.admin_id', '=', $admin_id)
					->get();
		}

//		//对获得数组进行一些处理
//		foreach ($pri_data as $k=>$v) {
//			if ($v->parent_id==0) {
//				foreach($pri_data as $k1=>$v1){
//					if($v1->parent_id == $v->id){
//						$v->children[] = $v1;
//					}
//				}
//				$menu[] = $v;
//			}
//		}

		return view('admin.menu',compact('pri_data'));
	}


}
