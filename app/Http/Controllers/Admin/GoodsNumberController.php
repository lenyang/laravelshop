<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Goods;
use App\Http\Model\GoodsNumber;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GoodsNumber $goodsNumber,$id)
    {

        //根据id取出商品名称
        $goods_name = (new Goods)->getGoodsNameById($id);
        //取出这件商品已有的存库数据

        $exist_goods_store = $goodsNumber->get_exist_goods_store($id);

        //取出这件商品的所有可选属性
        $goodsAttrData = $goodsNumber->get_goods_attrs($id);

        //将二维数组转三维,方便在库存页面中循环

        $storeData = [];

        foreach ($goodsAttrData as $v) {
            $storeData[$v->attr_id][] = $v;
        }

        return view('admin/goodsnumber/lst')->with([
            'page_btn_link'      => "/admin/goods",
            'page_btn_name'      => '商品列表',
            'page_btn_title'     => '货物列表',
            'storeData'          => $storeData,
            'goods_name'         => $goods_name,
            'exist_goods_store'  => $exist_goods_store,
            'goods_id'           => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->except('_token');
        //先删除原来的商品库存

        DB::table('goods_number')
            ->where('goods_id', '=', $input['goods_id'])
            ->delete();

        //判断一共多少中选择,方法是用attr数组的长度除以goods_number的长度
        //构造一个新的三维数组
        $attr_length = count($input['attr']);

        $goods_num_length = count($input['goods_number']);

        $ratio = $attr_length/$goods_num_length;

        static $number = 0;

        $arr = [];

        for($j=0;$j<$goods_num_length;$j++) {
            for ($i = 0; $i < $ratio; $i++) {
                $arr[$j][] = $input['attr'][$number];
                $number++;
            }
        }

        $attr_arr = [];
     //将属性数组处理一下,先按从小到大到大排列,然后用'-'号连接起来
        foreach($arr as $k=>$v){
            sort($v);
            $attr_arr[] = implode(',', $v);
        }
      //  dd($attr_arr);
        //数据入库
        foreach($attr_arr as $k=>$v){
        $res = DB::table('goods_number')
            ->insert([
            'goods_id'      =>   $input['goods_id'],
            'goods_number'  =>   $input['goods_number'][$k],
            'goods_attr_id' =>   $v
            ]);
        }

        if($res){
         return redirect('admin/goods')->with('msg','添加库存成功');
        }else{
         return back()->withErrors('添加库存失败!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function removeGoodsStore(Request $request){
        $goods_attr_id = $request->goods_attr_id;

        $res = DB::table('goods_number')
            ->where('goods_attr_id', '=', $goods_attr_id)
            ->delete();
        if($res){
            return array(
                'msg'      =>  '库存删除成功',
                'status'   =>  '1'
            );
        }else{
            return array(
                'msg'      =>  '库存删除失败',
                'status'   =>  '0'
            );
        }
    }


}
