<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Model\category;
    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;

    class CategoryController extends IndexController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            //
            $categorys =  (new category)->getTree();

            return view('admin.category.lst')->with(['page_btn_link'=>"/admin/category/create",'page_btn_name'=>'添加分类','page_btn_title'=>'分类列表', 'categorys'=>$categorys]);
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
           // dd($catData);
            return view('admin.category.add')->with(['page_btn_link'=>"/admin/category",'page_btn_name'=>'分类列表','page_btn_title'=>'添加分类', 'catData'=>$catData]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request,Category $category)
        {
            $input = $request->except('_token');
            //dd($input);
            $this->validate($request, [
                'cat_name' => 'required|unique:category',
                'parent_id' => 'required',
            ]);
            $res = $category->create($input);
            if($res){
                return redirect('admin/category');
            }else{
                return back()->withInput()->with('msg', '添加分类失败');
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
        public function edit($category)
        {
            $catData = (new category)->getTree();
            return view('admin.category.edit')->with(['category'=>$category, 'catData'=>$catData, 'page_btn_link'=>"/admin/category/create",'page_btn_name'=>'添加分类','page_btn_title'=>'分类列表']);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $category)
        {
            //
            $data = $request->except('_token', '_method');
            $this->validate($request, [
                'cat_name' => 'required',
                'parent_id' => 'required',
            ]);
            $res = $category->update($data);
            if($res){
                return redirect('admin/category')->with('msg', '更新成功');
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
        public function destroy($category)
        {
            //

        }


    }
