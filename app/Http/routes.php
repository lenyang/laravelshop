<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    ############前台#################
    Route::group(['namespace'=>'Home'],function(){
        Route::get('/list/{id}','IndexController@listGoods');
        Route::get('/list/searchlist','IndexController@searchList');
        Route::get('/list/key/{key}','SearchController@keySearch');
        Route::get('/', 'IndexController@index');
        Route::get('/goods/{goods_id}','IndexController@showGoods');
        Route::any('/register', 'MemberController@register');
        Route::post('/index/displayHistory', 'IndexController@displayHistory');
        Route::get('/savelogin', 'MemberController@saveAndLogin');
        Route::post('/addcomment', 'CommentController@store');
        Route::get('/getmemberprice/{goods_id}', 'MemberController@getMemberPrice');
        Route::any('/cart/store', ['as'=>'cartStore','uses'=>'CartController@store']);
        Route::any('/cart/order', ['as'=>'cartOrder','uses'=>'CartController@order']);
        Route::post('/cart/ajaxUpdateGoods', 'CartController@ajaxUpdateGoods');
        Route::get('/cart/ajaxGetGoods', 'CartController@ajaxGetGoods');
        Route::get('/cart/index', 'CartController@index');
        Route::post('/order/store', 'OrderController@store');
        Route::get('/order/receive', 'OrderController@receive');
        Route::any('/login', 'MemberController@login');
        Route::any('/logout', 'MemberController@logout');
        Route::any('/code', 'MemberController@code');
        Route::get('/emailchk/uid/{uid}/code/{code}', 'MemberController@emailchk');
    });




    ###########后台登陆界面###########
    Route::any('admin/login','Admin\LoginController@login');
    ###########后台生成验证码界面###########
    Route::any('admin/code','Admin\LoginController@code');

    Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'admin.islogin'],function(){
    Route::get('index','IndexController@index');
    ###########后台主页#############
    Route::get('top','IndexController@top');
    Route::get('main','IndexController@main');
    Route::get('menu','IndexController@menu');
    Route::post('changeuse','AdminController@changeIsUse');

        ######后台退出界面############
    Route::get('logout','LoginController@logout');
        #########权限资源############
    Route::resource('privilege','PrivilegeController');
        #########角色资源############
    Route::resource('role','RoleController');
        #########管理员资源############
    Route::resource('admin','AdminController');
        #########类型资源############
    Route::resource('type','TypeController');
        #########分类资源############
    Route::resource('category','CategoryController');
        #########商品资源############
    Route::resource('goods','GoodsController');
        #########商品库存管理############
    Route::get('goodsnumber/{goods_id}','GoodsNumberController@index');
    Route::post('goodsnumber/delete','GoodsNumberController@removeGoodsStore');
    Route::post('goodsnumber/store', 'GoodsNumberController@store');
        #########加入商品回收站#######
    Route::get('goods/{goods_id}/recycle','GoodsController@recycle');
        #########商品回收站列表#######
    Route::get('goodstore/recyclelist','GoodsController@recycleList');
        #########商品回收站还原#######
    Route::get('goods/{goods_id}/restore','GoodsController@restore');
        #########会员资源############
    Route::resource('memberlevel','MemberLevelController');
        #########商品属性路由,因为要用到类型id,不用资源路由######
    Route::get('attribute/create/{type_id?}', 'AttributeController@create');
    Route::post('attribute', 'AttributeController@store');
    Route::get('attribute/{type_id?}', 'AttributeController@index');
    Route::get('attribute/val/{val}', 'AttributeController@index');

        ##############ajax获取类型对应的属性############
    Route::post('ajaxGetAttr', 'TypeController@ajaxGetAttr');
        ##############ajax删除删除图片####################
    Route::post('goods/ajaxDeleteImage', 'GoodsController@deleteImage');
    });


Route::get('/home', 'HomeController@index');
