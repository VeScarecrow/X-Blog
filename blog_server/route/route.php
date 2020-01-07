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

Route::group('', function () {
    /**
     * 文章模块
     */
    Route::group('article', function () {
        Route::rule('/findAll', '/findAll', 'get|post');

        Route::rule('/findById', '/findById', 'get|post');

        Route::rule('/findByPage', '/findByPage?site=backed', 'get|post');

        Route::rule('/findByPageForSite', '/findByPage?site=fronted', 'get|post');

        Route::rule('/save', '/save', 'get|post');

        Route::rule('/update', '/update', 'get|post');

        Route::rule('/search', '/search', 'get|post');

        Route::rule('/delete', '/deleteById', 'get|post');

        Route::rule('/findArchives', '/findArchives', 'get|post');

        Route::rule('/findCountByArticleId', '/findCountByArticleId', 'get|post');
    })->prefix('admin/ArticleController');

    /**
     * 文章分类模块
     */
    Route::group('category', function () {
        Route::rule('/findByPage', '/findByPage', 'get|post');

        Route::rule('/delete', '/deleteById', 'get|post');

        Route::rule('/save', '/save', 'get|post');

        Route::rule('/update', '/update', 'get|post');

        Route::rule('/findByName', '/findByName', 'get|post');
    })->prefix('admin/CategoryController');

    /**
     * 文章链接模块
     */
    Route::group('links', function () {
        Route::rule('/findAll', '/findAll', 'get|post');

        Route::rule('/findByPage', '/findByPage', 'get|post');

        Route::rule('/delete', '/deleteById', 'get|post');

        Route::rule('/save', '/save', 'get|post');

        Route::rule('/update', '/update', 'get|post');
    })->prefix('admin/LinksController');

    /**
     * 文章评论模块
     */
    Route::group('comments', function () {
        Route::rule('/findAll', '/findAll', 'get|post');

        Route::rule('/findByPage', '/findByPage', 'get|post');

        Route::rule('/save', '/save', 'get|post');

        Route::rule('/findCommentsList', '/findCommentsList', 'get|post');

        Route::rule('/delete', '/deleteById', 'get|post');
    })->prefix('admin/CommentsController');

    /**
     * 文章标签模块
     */
    Route::group('tags', function () {
        Route::rule('/findByPage', '/findByPage', 'get|post');

        Route::rule('/save', '/save', 'get|post');

        Route::rule('/update', '/update', 'get|post');

        Route::rule('/delete', '/deleteById', 'get|post');
    })->prefix('admin/TagsController');

    /**
     * 文件上传/下载模块
     */
    Route::group('storage', function () {
        Route::rule('/upload', '/upload');

        Route::rule('/download/:url', '/download');
    })->prefix('admin/UploadController');

    /**
     * 登陆验证模块
     */
    Route::rule('admin/login', 'admin/UserController/login', 'get|post');

    Route::rule('user/info', 'admin/UserController/getUserInfo');

})->middleware('CrossDomain')->allowCrossDomain();

//return [
//
//];
