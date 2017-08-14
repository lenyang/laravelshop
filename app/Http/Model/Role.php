<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    //
	protected $table = 'role';
	protected $fillable = ['role_name'];
	public $timestamps = false;


	//新加入一条数据后将其插入到中间表中
	public function add_role_privilege($id, $priIds){
		foreach($priIds as $v){
			DB::table('role_privilege')->insert(
					['role_id'=>$id, 'pri_id'=>$v]
			);
		}

	}

	/**
	 * 获取角色所对应的权限名
	 *
	 */

	public function get_role_privilege(){
		$data = DB::table('role as r')->select(DB::raw('GROUP_CONCAT(php32_p.pri_name) pri_name'), 'r.id', 'r.role_name')
				->leftJoin('role_privilege as rp', 'r.id', '=', 'rp.role_id')
				->leftJoin('privilege as p', 'p.id', '=', 'rp.pri_id')->groupBy('r.id')->get();
		return $data;
	}

	/**
	 * 获取角色所拥有的全部权限id
	 */
	public function get_privilege_ids($id){
		return $priIds = DB::table('role_privilege')->where('role_id', '=', $id)->get();
	}

	/**
	 * 删除角色权限中间表对应的权限id
	 */
	public function del_privileges($id){
		DB::table('role_privilege')->where('role_id', '=', $id)->delete();
	}

	/**
	 * 取出所有的角色
	 */
	public function get_all_roles(){
		return $roles = DB::table('role')->get();
	}
}

