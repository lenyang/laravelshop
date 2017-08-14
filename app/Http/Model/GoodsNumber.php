<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsNumber extends Model
{
    //
	protected $table = 'goods_number';
	public $timestamps = false;

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function get_goods_attrs($id){
		return $data = DB::table('goods_attr as a')
			->leftJoin('attribute as b', 'b.id', '=', 'a.attr_id')
			->where('a.goods_id', '=', $id)
			->where('b.attr_type', '=', '1')
			->select('a.id','a.attr_id', 'a.attr_value', 'b.attr_name')
			->get();
	}

	public function get_exist_goods_store($id){
		return $data = DB::table('goods_number')
			->where('goods_id', '=', $id)
			->get();
	}
}
