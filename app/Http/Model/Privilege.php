<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $table = 'privilege';
	protected $fillable = ['parent_id', 'pri_name', 'module_name', 'controller_name', 'action_name'];
	public $timestamps = false;

	/**
	 * 无限分类取数据
	 */
	public function _getTree($data, $p_id=0, $level=0){
		static $arr = array();
		foreach($data as $k=>$v){
			if($v['parent_id'] == $p_id){
				$v['level'] = $level;
				$arr[] = $v;
				$this->_getTree($data, $v['id'], $level+1);
			}
		}
		return $arr;
	}

	/**
	 * 取出权限分类下的数据
	 */
	public function getTree(){
		$data = $this->get();
		return $this->_getTree($data);
	}
}
