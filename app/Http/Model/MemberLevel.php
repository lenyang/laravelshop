<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    //
	protected $table = 'member_level';
	public $timestamps = false;
	protected $fillable = ['level_name', 'bottom_num', 'top_num', 'rate'];
}
