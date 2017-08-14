<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Type extends Model
{
    //
	protected $table = 'type';
	public $timestamps = false;
	protected $fillable = ['type_name'];

	/**
	 * 取出所有的类型及其每个类型的属性总量
	 */
	public function get_all_types(){
		return $data = DB::table('type as a')
				->leftJoin('attribute as b', 'a.id', '=', 'b.type_id')
				->select(DB::raw('count(*) as attr_num, php32_a.*'))
				->groupBy('a.id')
				->get();
	}
}
