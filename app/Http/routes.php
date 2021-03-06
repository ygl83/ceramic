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

get('/', function () {
    return redirect('/goods');
});

get('goods', 'GoodsController@index');
//get('goods/{id}', 'GoodsController@showPost');

//文件上传
Route::post( 'goods/upload', 'FileUploadController@upload' );
Route::get( 'goods/file_remove/{Uuid}/{AdUuid}', 'FileUploadController@remove' );

get('admin', function () {
    return redirect('/admin/goods_manage');
});
$router->group(['namespace' => 'Admin', 'middleware' => 'auth'], function () {
    resource('admin/goods_manage', 'GoodsManageController');
    Route::get( 'admin/goods_manage/delete/{id?}','GoodsManageController@delete' );
    Route::post( 'admin/goods_manage/ajax','GoodsManageController@ajax' );
    get('admin/upload', 'UploadController@index');

    //banner
    resource('admin/banner', 'BannerController');
    Route::get( 'admin/banner/delete/{id?}','BannerController@delete' );

});

// Logging in and out
get('/auth/login', 'Auth\AuthController@getLogin');
post('/auth/login', 'Auth\AuthController@postLogin');
get('/auth/logout', 'Auth\AuthController@getLogout');