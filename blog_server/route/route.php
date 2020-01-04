<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

//Route::get('hello/:name', 'index/hello');
//Route::rule('user/info', 'admin/UserController/getUserInfo', 'get|post')
//    ->header('Access-Control-Allow-Origin', '*')
//    ->header('Access-Control-Allow-Headers', '*')
//    ->header('Access-Control-Allow-Methods', '*')
//    ->allowCrossDomain();
;

Route::group('', function () {

    Route::rule('article/findAll', 'admin/ArticleController/findAll', 'get|post');

    Route::rule('article/findById', 'admin/ArticleController/findById', 'get|post');

    Route::rule('article/findByPage', 'admin/ArticleController/findByPage', 'get|post');

    Route::rule('article/findByPageForSite', 'admin/ArticleController/findByPage', 'get|post');

    Route::rule('article/save', 'admin/ArticleController/save', 'get|post');

    Route::rule('article/update', 'admin/ArticleController/update', 'get|post');

    Route::rule('article/search', 'admin/ArticleController/search', 'get|post');

    Route::rule('article/delete', 'admin/ArticleController/deleteById', 'get|post');

    Route::rule('article/findArchives', 'admin/ArticleController/findArchives', 'get|post');

    Route::rule('article/findCountByArticleId', 'admin/ArticleController/findCountByArticleId', 'get|post');

    Route::rule('category/findByPage', 'admin/CategoryController/findByPage', 'get|post');

    Route::rule('category/delete', 'admin/CategoryController/deleteById', 'get|post');

    Route::rule('category/save', 'admin/CategoryController/save', 'get|post');

    Route::rule('category/update', 'admin/CategoryController/update', 'get|post');

    Route::rule('links/findAll', 'admin/LinksController/findAll', 'get|post');

    Route::rule('links/delete', 'admin/LinksController/deleteById', 'get|post');

    Route::rule('links/save', 'admin/LinksController/save', 'get|post');

    Route::rule('comments/findAll', 'admin/CommentsController/findAll', 'get|post');

    Route::rule('comments/findByPage', 'admin/CommentsController/findByPage', 'get|post');

    Route::rule('comments/save', 'admin/CommentsController/save', 'get|post');

    Route::rule('comments/findCommentsList', 'admin/CommentsController/findCommentsList', 'get|post');

    Route::rule('comments/delete', 'admin/CommentsController/deleteById', 'get|post');

    Route::rule('tags/findByPage', 'admin/TagsController/findByPage', 'get|post');

    Route::rule('tags/save', 'admin/TagsController/save', 'get|post');

    Route::rule('tags/update', 'admin/TagsController/update', 'get|post');

    Route::rule('tags/delete', 'admin/TagsController/deleteById', 'get|post');

    Route::rule('admin/login', 'admin/UserController/login', 'get|post');

    Route::rule('user/info', 'admin/UserController/getUserInfo');

})->middleware('CrossDomain')->allowCrossDomain();

//return [
//
//];
