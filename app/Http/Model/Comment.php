<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    //
	protected $table = 'comment';
	protected $fillable = ['member_id', 'goods_id', 'content', 'addtime', 'star'];
	public $timestamps = false;

    public function add_impression($imp_data, $goods_id){
		//将提交过来的印象的中文,号换成英文,号
		$imp_data = str_replace('，', ',', $imp_data);
		$imp_data = explode(',', $imp_data);
		foreach($imp_data as $k=>$v){
         //判断这个印象是否出现过
			$has = DB::table('impression')
				->where('imp_name', '=', $v)
				->where('goods_id', '=', $goods_id)
				->lists('imp_name');
			if($has){
				DB::table('impression')
					->where('imp_name', '=', $v)
					->where('goods_id', '=', $goods_id)
					->increment('imp_count', 1);
			}else{
				DB::table('impression')
					->insert([
						'imp_name' => $v,
						'goods_id' => $goods_id,
					]);
			}
		}
	}
}
