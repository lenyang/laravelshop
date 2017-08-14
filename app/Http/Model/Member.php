<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    //
	protected $table = 'member';
	public $timestamps = false;
	protected $fillable = ['email', 'password', 'addtime', 'email_code'];

	/**
	 * @param $email
	 *
	 * @return mixed
	 */
	public function get_user_info($email){
		return $data = $this->where('email', $email)->first();
	}

	/**
	 * @param $jifen
	 *
	 * @return mixed
	 */
	public function get_user_level($jifen)
	{
		return $level = DB::table('member_level')
				->where('bottom_num', '<=', $jifen)
				->where('top_num', '>=', $jifen)
				->select('id', 'rate')
				->get();
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function check_email_status($id){
		return $res = DB::table('member')
				->where('id', '=', $id)
				->lists('email_code');
	}

	public function get_member_price($goods_id){
		//取出商品是否促销
		$today = mktime(23,59,59,date('m'),date('d'), date('Y'));

		$goods_info = DB::table('goods')
				->where('id', '=', $goods_id)
				->lists('shop_price');


		$promote_info = DB::table('goods')
				->where('is_promote', '=', 1)
				->where('promote_start_time', '<', $today)
				->where('promote_end_time', '>', $today)
				->where('id', '=', $goods_id)
				->lists('promote_price');
		//会员id
		$member_id = session('member_id');
		//会员级别id
		$member_level_id = session('member_level_id');
		if($member_id){
			//根据会员级别id取出对应的商品
			$member_price = DB::table('member_price')
					->where('level_id', '=', $member_level_id)
					->lists('price');

			if($member_price=='-1'){
				//根据对应的折扣率进行计算
				$member_price[0] = (session('rate')/100)*$goods_info[0];
			}
			if($promote_info){
				return $data = min($promote_info[0], $member_price[0]);
			}else{
				return $data = $member_price[0];
			}
		}else{
			if($promote_info) {
				return $data = $promote_info[0];
			}else{
				return $data = $goods_info[0];
			}
		}
	}
}
