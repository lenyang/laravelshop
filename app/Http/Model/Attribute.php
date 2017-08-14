<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attribute extends Model
{
    //
	protected $table = 'attribute';
    public $timestamps = false;
	protected $fillable = ['attr_name','attr_type','attr_value', 'type_id'];

	/**
	 * 获取所有的属性名及其所对应的类型
	 *
	 */

	public function get_all_attributes($type_id){
		if(!empty($type_id)){
			return $data = DB::table('attribute as a')->select('a.*','b.type_name')
				->leftJoin('type as b', 'a.type_id', '=', 'b.id')
				->where('b.id', '=',$type_id)
				->get();
		}else{
			return $data = DB::table('attribute as a')->select('a.*','b.type_name')
				->leftJoin('type as b', 'a.type_id', '=', 'b.id')
				->get();
		}

	}
}
