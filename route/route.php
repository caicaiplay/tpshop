<?php

// 前台路由
Route::rule('cate/:id', 'index/index/index');
Route::any('/', 'index/index/index');
Route::rule('content/:id','index/article/content');
Route::rule('register', 'index/index/register');
Route::rule('login','index/index/login');
Route::rule('contribute','index/article/contribute');
Route::rule('loginout', 'index/index/loginout', 'get|post');
Route::rule('search', 'index/index/search', 'get');
Route::rule('comment', 'index/article/comment', 'post');
// 后台路由
Route::group('admin', function () {
    Route::any('/', 'admin/index/login');
    Route::any('register', 'admin/index/register');
    Route::any('forget', 'admin/index/forget');
    Route::post('reset', 'admin/index/reset');
    Route::any('updatepass', 'admin/index/updatePass');
    Route::get('home', 'admin/home/index');
    Route::post('loginout', 'admin/home/loginOut');
    Route::rule('catelist', 'admin/cate/lister', 'get|post');
    Route::rule('cateadd', 'admin/cate/add', 'get|post');
    Route::post('catesort', 'admin/cate/sort');
    Route::any('cateedit/[:id]', 'admin/cate/edit');
    Route::post('cateupadte', 'admin/cate/update');
    Route::post('catedel', 'admin/cate/del');
    Route::any('articleadd', 'admin/article/add');
    Route::any('articlelist', 'admin/article/lister');
    Route::post('articletop', 'admin/article/top');
    Route::any('articleedit/[:id]', 'admin/article/edit');
    Route::post('articledel', 'admin/article/del');
    Route::any('memberadd', 'admin/member/add');
    Route::any('memberlist', 'admin/member/lister');
    Route::any('memberedit/[:id]', 'admin/member/edit');
    Route::post('memberdel', 'admin/member/del');
    Route::rule('adminadd', 'admin/admin/add', 'get|post');
    Route::rule('adminlist', 'admin/admin/lister', 'get|post');
    Route::post('admindel', 'admin/admin/del');
    Route::any('adminedit/[:id]', 'admin/admin/edit');
    Route::post('adminstatus', 'admin/admin/status');
    Route::rule('comment', 'admin/comment/lists', 'get|post');
    Route::post('commentdel', 'admin/comment/del');
    Route::any('test', 'admin/test/test');
    Route::any('systemset', 'admin/system/set');
});


