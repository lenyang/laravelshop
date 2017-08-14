<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    //
	protected $table = 'admin';

	protected  $fillable = ['username', 'password', 'is_use'];

	public $timestamps = false;


	/**
	 * 存入数据到管理员角色中间表
	 */
	public function add_admin_role($admin_id, $roleIds){
		foreach ($roleIds as $v) {
			$res =DB::table('admin_role')->insert(
					['admin_id'=>$admin_id, 'role_id'=>$v]
			);

		}
		return $res;
	}

	/**
	 * 取出管理员所属的全部角色
	 * @param int id
	 * @return array
	 */

	public function get_admin_roles($id){
		return $roleIds = DB::table('admin_role')->where('admin_id','=', $id)->get();
	}

	/**
	 *  删除管理员所对应的角色
	 */
	public function del_admin_roles($id){
		return $res = DB::table('admin_role')->where('admin_id', '=', $id)->delete();
	}
}
