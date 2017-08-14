<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Model\memberlevel;
    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;

    class MemberLevelController extends IndexController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            //
            $memberlevels =  (new memberlevel)->get();

            return view('admin.memberlevel.lst')->with(['page_btn_link'=>"/admin/memberlevel/create",'page_btn_name'=>'添加会员','page_btn_title'=>'会员列表', 'memberlevels'=>$memberlevels]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {

            // 取出所有的会员数据
            $catData = (new memberlevel)->get();
            // dd($catData);
            return view('admin.memberlevel.add')->with(['page_btn_link'=>"/admin/memberlevel",'page_btn_name'=>'会员列表','page_btn_title'=>'添加会员', 'catData'=>$catData]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request,MemberLevel $memberlevel)
        {
            $input = $request->except('_token');
           // dd($input);
            $this->validate($request, [
                'level_name' => 'required|unique:member_level',
                'bottom_num' => 'required|numeric',
                'top_num' => 'required|numeric',
                'rate' => 'required|digits_between:1,3|min:1|max:100',
            ]);
            $res = $memberlevel->create($input);
            //dd(lastSql());
            if($res){
                return redirect('admin/memberlevel');
            }else{
                return back()->withInput()->with('msg', '添加会员失败');
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
        public function edit(MemberLevel $memberlevel)
        {

            return view('admin.memberlevel.edit')->with(['memberlevel'=>$memberlevel, 'page_btn_link'=>"/admin/memberlevel/create",'page_btn_name'=>'添加会员','page_btn_title'=>'会员列表']);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $memberlevel)
        {
            //
            $data = $request->except('_token', '_method');
            $this->validate($request, [
                'level_name' => 'required|unique:member_level',
                'bottom_num' => 'required|numeric',
                'top_num' => 'required|numeric',
                'rate' => 'required|digits_between:1,3|min:1|max:100',
            ]);
            $res = $memberlevel->update($data);
            if($res){
                return redirect('admin/memberlevel')->with('msg', '更新成功');
            }else{
                return back()->withInput()->with('errors', '更新失败');
            }
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($memberlevel)
        {
            //

        }
    }
