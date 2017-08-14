<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;
use App\Http\Requests;
use App\Http\Model\Goods;
use App\Http\Model\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //取出所有的商品数据
        $goods = DB::table('goods')->where('is_delete', '=', 0)->paginate(2);
        return view('admin/goods/lst')->with([
            'page_btn_link'  => "/admin/goods/create",
            'page_btn_name'  => '添加新商品',
            'page_btn_title' => '商品列表',
            'goods'          => $goods
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // 取出所有的分类数据
        $catData = (new category)->getTree();

        //取出所有的会员数据
        $memData = DB::table('member_level')->get();

        //取出所有的类型数据
        $types = DB::table('type')->get();

        return view('admin.goods.add')->with([
            'page_btn_link'  => "/admin/goods",
            'page_btn_name'  => '商品列表',
            'page_btn_title' => '添加新商品',
            'memData'        => $memData,
            'catData'        => $catData,
            'types'          => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Goods $goods)
    {
        $input = $request->except('_token');

        $rules = [
            'goods_name'        => 'required|unique:goods',
            'cat_id'            => 'required',
            'logo'              => 'required',
            'shop_price'        => 'required',
            'market_price'      => 'required',
            'is_on_sale'        => 'required|in:0,1',
            'is_new'            => 'sometimes|required|in:0,1',
            'is_hot'            => 'sometimes|required|in:0,1',
            'is_best'           => 'sometimes|required|in:0,1',
            'sort_num'          => 'required|numeric',
            'is_best'           => 'sometimes|required|in:0,1',
            'promote_start_time'=> 'sometimes|required',
            'promote_end_time'  => 'sometimes|required',
            'type_id'           => 'required'
        ];

        $message = [
            'required'     =>  '这个:attribute不能为空',
            'numeric'      =>  '这个:attribute一定要是数字',
            'in'           =>  '这个:attribute只能选\'是\'或者\'否\''
        ];

        $validator = Validator::make($input, $rules, $message);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }

        if ((isset($input['promote_start_time'])) && (isset($input['promote_end_time']))) {

            $input['promote_start_time'] = strtotime($input['promote_start_time']);

            $input['promote_end_time'] = strtotime($input['promote_end_time']);
        }

        $input['addtime'] = time();

        //得到上传的图片和相应的略缩图信息
        $file = Input::file('logo');

        if($file->isValid()){

            $res = uploadOne($file, 'uploads/', [[100,100]]);
        }
        $input['logo'] = $res['images'][0];

        $input['sm_logo'] = $res['images'][1];

        $goods_ins = $goods->create($input);

        $goods_id = $goods_ins->id;


        #########添加完商品基本信息后,完成其他表的操作############

        //将会员价格信息存储到会员价格中间表
        $goods->add_member_price($goods_id, $input['level_price']);

        //将属性数据存到商品属性表中
        $goods->add_goods_attr($goods_id,$input['ga'],$input['price']);

        //将上传的多张商品图片保存并制作相应的略缩图
        $files = Input::file('imgs');

        foreach($files as $file){
            if(is_null($file)){
              continue;
            }
            if($file->isValid()){
                $res = uploadOne($file,'uploads/Goods/',[[100,100]]);
                //将图片数据加入到商品图片表中
               $goods->add_goods_pics($goods_id,$res);
            }
        }
        return redirect('admin/goods');

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
    public function edit(Request $request, Goods $goods)
    {

        // 取出所有的分类数据
        $catData = (new category)->getTree();

        //取出所有的会员数据及其对应的会员价格
       $memData = $goods->select_member_data($goods->id);

        //取出所有的类型数据
        $types = DB::table('type')->get();

        //取出该件商品对应的图片
        $pics = $goods->get_goods_pics($goods->id);

        //取出这件商品对应的属性名称和值
        $goodsAttrs = $goods->get_goods_attributes($goods->id);


        //判断商品所属的类型中是否有新增的属性
        $otherAttrs = $goods->get_other_attributes($goodsAttrs, $goods);

        if($goodsAttrs && $otherAttrs){
        //将新增属性和原有的属性合并
        $goodsAttrs = array_merge( $goodsAttrs,$otherAttrs);
        }
        //dd($goodsAttrs);
        return view('admin.goods.edit')->with([
            'page_btn_link'  => "/admin/goods",
            'page_btn_name'  => '商品列表',
            'page_btn_title' => '编辑新商品',
            'memData'        => $memData,
            'catData'        => $catData,
            'types'          => $types,
            'goods'          => $goods,
            'pics'           => $pics,
            'goodsAttrs'     => $goodsAttrs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Goods  $goods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Goods $goods)
    {
        //提交的所有的商品更新数据
        $input = $request->except('_token','_method');

        //需要更新的基本商品信息
        $goods_data = $request->except('_token','_method','level_price','old_ga','old_price','ga','price','imgs');

        //先更新商品基本信息
        $rules = [
            'goods_name'        => 'sometimes|required',
            'cat_id'            => 'sometimes|required',
            'logo'              => 'sometimes|required',
            'shop_price'        => 'sometimes|required',
            'market_price'      => 'sometimes|required',
            'is_on_sale'        => 'sometimes|required|in:0,1',
            'is_new'            => 'sometimes|required|in:0,1',
            'is_hot'            => 'sometimes|required|in:0,1',
            'is_best'           => 'sometimes|required|in:0,1',
            'sort_num'          => 'sometimes|required|numeric',
            'is_best'           => 'sometimes|required|in:0,1',
            'promote_start_time'=> 'sometimes|required',
            'promote_end_time'  => 'sometimes|required',
            'type_id'           => 'sometimes|required'
        ];

        $message = [
            'required'     =>  '这个:attribute不能为空',
            'numeric'      =>  '这个:attribute一定要是数字',
            'in'           =>  '这个:attribute只能选\'是\'或者\'否\''
        ];

        $validator = Validator::make($goods_data, $rules, $message);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();

        }


        //判断是否修改了logo
        if(isset($goods_data['logo'])){
            //先从硬盘上删除原来照片和略缩图照片

            $goods->delete_goods_image($goods->id);

            $file = Input::file('logo');

            if($file->isValid()){

                $res = uploadOne($file, 'uploads/', [[100,100]]);
            }
            $goods_data['logo'] = $res['images'][0];

            $goods_data['sm_logo'] = $res['images'][1];
        }

        //判断是否修改为促销
        if ((isset($goods_data['promote_start_time'])) && (isset($goods_data['promote_end_time']))) {

            $goods_data['promote_start_time'] = strtotime($goods_data['promote_start_time']);

            $goods_data['promote_end_time'] = strtotime($goods_data['promote_end_time']);
        }
       #########会员价格进行更新#############
       $memberData = $input['level_price'];

       $goods->update_member_price($memberData, $goods);

       #########商品属性进行更新#############
       $old_ga_data = $input['old_ga'];

       $old_ga_price = $input['old_price'];

       $goods->update_old_ga($old_ga_data, $old_ga_price, $goods);

        //添加新属性,如果需要的话
        if(isset($input['ga']) && isset($input['price'])){
            $ga = $input['ga'];

            $price = $input['price'];

            $goods->add_goods_attr($goods->id, $ga, $price);
        }

       #########商品图片进行更新#############
        $files = Input::file('imgs');

        foreach($files as $file){
           if(is_null($file)){
               continue;
           }
            if($file->isValid()){
                $res = uploadOne($file,'uploads/Goods/',[[100,100]]);
                //将图片数据加入到商品图片表中
                $goods->add_goods_pics($goods->id,$res);
            }
        }

       $res = $goods->where('id', '=', $goods->id)->update($goods_data);

        if($res){
            return redirect('admin/goods')->with('msg','更新成功');
        }else{
            return back()->withErrors('更新失败')->withInput();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goods $goods)
    {
        //

        ########删除会员表中的基本信息#########
        $goods->delete_member_price($goods);

        ########删除商品属性表中的基本信息#########
        $goods->delete_goods_attr($goods);

        ########删除商品图片表中的基本信息#########
        $goods->delete_goods_pics($goods);

        ########删除库存表中的基本信息#########
        $goods->delete_goods_store($goods);

        ########删除商品表中的基本信息#########
        //删除logo
        $goods->delete_goods_image($goods->id);

        $res = $goods->delete();

        if($res){
            return array(
                'msg'      =>  '商品删除成功',
                'status'   =>  '1'
            );
        }else{
            return array(
                'msg'      =>  '商品删除失败',
                'status'   =>  '0'
            );
        }
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function deleteImage(Request $request){
        $id = $request->id;


        //找到图片的地址,将图片从硬盘上删除
        $images = DB::table('goods_pics')
            ->where('id','=',$id)
            ->select('pic','sm_pic')
            ->get();

        foreach($images as $image){
             chmod('./'.$image->pic, 0777);
            $res1 = unlink('./'.$image->pic);
             chmod('./'.$image->sm_pic, 0777);
            $res2 = unlink('./'.$image->sm_pic);

        }
        //从商品图片表中将该图片删除

        DB::table('goods_pics')
            ->where('id', '=', $id)
            ->delete();
        if($res1 && $res2){
            return array(
                'status' => '1',
                'msg'    => '删除图片成功'
            );
        }else{
            return array(
                'status' => '0',
                'msg'    => '删除图片失败'
            );
        }

    }


    /**
     * @param Request $request
     * @param $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function recycle(Request $request, $id){
        //将对应的商品的is_delete属性进行设置
        $res = DB::table('goods')
            ->where('id', $id)
            ->update(['is_delete' => 1]);

        if($res){
          return redirect('admin/goods')->with('msg','放入回收站成功!');
        }else{
            return back()->withErrors('放入回收站失败!');
        }
    }

    /**
     * @param Goods $goods
     *
     * @return $this
     */
    public function recycleList(Goods $goods){
        //取出is_delete为1的所有商品
        $data = $goods->get_is_delete_goods();
        return view('admin.goods.recycle')->with([
            'page_btn_link'  => "/admin/goods",
            'page_btn_name'  => '商品列表',
            'page_btn_title' => '商品回收站',
            'goods'          =>$data
        ]);
    }

    public function restore($id){
        $res = DB::table('goods')
            ->where('id', '=', $id)
            ->update(['is_delete' => '0']);
        if($res){
          return redirect('admin/goods')->with('msg','还原商品成功');
        }else{
            return back()->withErrors('还原商品失败!');
        }
    }

}
