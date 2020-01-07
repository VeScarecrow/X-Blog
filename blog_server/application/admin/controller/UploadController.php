<?php


namespace app\admin\controller;


use app\common\dto\Result;
use think\Controller;
use think\Exception;

/**
 * 文件上传/下载接口
 * Class UploadController
 * @package app\admin\controller
 */
class UploadController extends Controller
{
    public function upload()
    {
        try {
            // 获取表单上传文件
            $files = request()->file();
            if (count($files, 0) > 5) {
                return json(Result::parError()->toJson());
            }
            foreach ($files as $file) {
                // 移动到框架应用根目录/static/uploads/ 目录下
                //限制大小和类型
                $info = $file->validate(['size' => 1024 * 1024, 'ext' => 'jpg,png,jpeg,gif'])->rule('md5')->move('../public/static/uploads/');
                if ($info) {
                    $url = 'http://xcoding.com:8080/static/uploads/' . str_replace('\\', '/', $info->getSavename());
                    return json(Result::success($url)->toJson());
                } else {
                    // 上传失败获取错误信息
                    return json(Result::innerError()->toJson());
                }
            }
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    /**
     * 文件下载
     * @param string $url 地址
     * @return \think\response\Download|\think\response\Json
     */
    public function download($url)
    {
        try {
            return download(env('../public/uploads/' . $url, 'image'))->expire(500);
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

}