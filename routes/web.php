<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
	return redirect('login');
});

//后台管理--显示登录页面
Route::get('/login','Admin\ManagerController@login')->name('login');
//后台管理--登录信息储存
Route::post('/storemanager','Admin\ManagerController@storemanager');

Route::group(['middleware'=>'auth:back'],function(){
	//后台管理--显示后台主页
	Route::get('/index/index','Admin\IndexController@index');
	//后台管理--显示welcome
	Route::get('/welcome','Admin\IndexController@welcome');
	//后台管理--退出登录
	Route::get('/logout','Admin\ManagerController@logout');
	//后台管理--修改密码
	Route::match(['get','post'],'/password','Admin\IndexController@password');

	//////////////////////////////////禁止翻墙///////////////////////////////////////
	Route::group(['middleware'=>'Fanqiang'],function(){

		//后台管理--显示权限列表
		Route::get('/permission/index','Admin\PermissionController@index');		//做了缓存 缓存驱动file
		//后台管理--显示添加权限
		Route::get('/permission/create','Admin\PermissionController@create');
		//后台管理--保存权限
		Route::post('/permission/store','Admin\PermissionController@store');
		//后台管理--显示编辑权限
		Route::get('/permission/show/{p_id}','Admin\PermissionController@show');
		//后台管理--保存编辑权限
		Route::post('/permission/save','Admin\PermissionController@save');
		//后台管理--删除权限
		Route::post('/permission/del','Admin\PermissionController@del');

		//后台管理--角色列表(用户组)
		Route::get('/role/index','Admin\RoleController@index');
		//后台管理--删除角色
		Route::post('/role/del','Admin\RoleController@del');
		//后台管理--显示添加用户组
		Route::get('/role/create','Admin\RoleController@create');
		//后台管理--添加保存
		Route::post('/role/store','Admin\RoleController@store');
		//后台管理--显示权限页面
		Route::get('/role/qxview/{r_id}','Admin\RoleController@qxview');
		//后台管理--保存分配权限
		Route::post('/role/qxsave','Admin\RoleController@qxsave');

		//后台管理--用户管理
		Route::match(['get','post'],'/manager/index','Admin\ManagerController@index');
		//后台管理--用户删除
		Route::post('/manager/del','Admin\ManagerController@del');
		//后台管理--用户修改状态
		Route::post('/manager/setstatus','Admin\ManagerController@setstatus');
		//后台管理--用户添加页面
		Route::get('/manager/create','Admin\ManagerController@create');
		//后台管理--用户添加保存
		Route::post('/manager/stroe','Admin\ManagerController@stroe');
		//后台管理--用户编辑显示
		Route::get('/manager/edit/{mg_id}','Admin\ManagerController@edit');
		//后台管理--用户编辑更新
		Route::post('/manager/update','Admin\ManagerController@update');
		//后台管理--超级用户给用户重置密码
		Route::match(['get','post'],'/manager/resetpwd/{mg_id?}','Admin\ManagerController@resetpwd');

		//后台管理--白名单
		Route::get('/whitelist','Admin\WhitelistController@index');
		//后台管理--保存白名单
		Route::post('/whitelist/store','Admin\WhitelistController@store');
		//后台管理--删除白名单
		Route::post('/whitelist/destroy','Admin\WhitelistController@destroy');

		/////////////////////////////////////////用户管理//////////////////////////////////////////
		//后台管理--客户信息
		Route::get('/client/show','Admin\ClientController@show');
		//后台管理--客户详情页面
		Route::get('/client/info/{u_id}','Admin\ClientController@info');
		//后台管理--编辑显示
		Route::get('/client/edit/{u_id}','Admin\ClientController@edit');
		//后台管理--编辑更新
		Route::post('/client/update','Admin\ClientController@update');

		//后台管理--客户导入
		Route::get('/client/index','Admin\ClientController@index');
		//后台管理--导入csv
		Route::post('/import','Admin\ServerController@import');
		//后台管理--数据回滚(物理)
		Route::post('/rollback','Admin\ServerController@rollback');

		//后台管理--模拟get请求
		Route::get('/http','Admin\HttpController@http');
		//后台管理--http请求
		Route::post('/upload','Admin\HttpController@upload');
		//后台管理--http请求操作
		Route::post('/todo','Admin\HttpController@todo');

		////////////////////////////////////////////回访管理//////////////////////////////////////////
		//后台管理--工作流显示
		Route::get('/work/index','Admin\WorkController@workflow');
		//后台管理--定时任务:(根据设置的规则进行读取客户数据库把未回访的写入任务表)
		Route::get('/work/jobs','Admin\WorkController@jobs');
		//后台管理--当天23:58 写入到统计表内
		Route::get('/work/total','Admin\WorkController@total');

		//后台管理--修改为正在处理中
		Route::post('/work/workingstatus','Admin\WorkController@workingstatus');
		//后台管理--显示添加回访记录
		Route::get('/work/add_visit/{j_id}/{u_id}','Admin\WorkController@add_visit');
		//后台管理--保存回访
		Route::post('/work/store','Admin\WorkController@store');
		//后台管理--回访记录
		Route::get('/work/visit','Admin\WorkController@visit');
		//后台管理--查看客户信息
		Route::get('/work/info/{u_id}','Admin\WorkController@info');
		//后台管理--会员的回访详情
		Route::get('/work/visitzi/{u_id}','Admin\WorkController@visitzi');
		//后台管理--退回重新回访
		Route::post('/work/rollback','Admin\WorkController@rollback');	//jobs sattus client sattus
		//后台管理--回访导出
		Route::get('/export/show','Admin\ServerController@show');
		//后台管理--回访操作
		Route::post('/export','Admin\ServerController@export');	
		//laravel 自带下载方法
		Route::get('/download/{file}', 'Admin\ServerController@download')->name('download');

		/////////////////////////////////////////////工作管理////////////////////////////////////////////
		//后台管理--回访统计
		Route::get('/count/index','Admin\CountController@index');
		//后台管理--当月统计
		Route::post('/count/month','Admin\CountController@month');
		//后台管理--天统计
		Route::get('/count/info/{mg_id}/{month}','Admin\CountController@info');

		/////////////////////////////////////////////分配工作///////////////////////////////////////////////
		//后台管理--分配工作
		Route::get('/fenpei/index','Admin\FenpeiController@index');
		//后台管理--添加显示
		Route::get('/fenpei/create','Admin\FenpeiController@create');
		//后台管理--添加保存
		Route::post('/fenpei/store','Admin\FenpeiController@store');
		//后台管理--显示编辑
		Route::get('/fenpei/edit/{f_id}','Admin\FenpeiController@edit');
		//后台管理--更新编辑
		Route::post('/fenpei/update','Admin\FenpeiController@update');
		//后台管理--删除分配
		Route::post('/fenpei/destroy','Admin\FenpeiController@destroy');
	});
});

