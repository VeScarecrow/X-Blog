<?php


namespace app\admin\controller;


use app\common\dto\Result;
use think\Controller;
use think\Exception;

class UploadController extends Controller
{
    public function upload()
    {
        try {
            // 获取表单上传文件
            $files = request()->file('image');
            foreach ($files as $file) {
                // 移动到框架应用根目录/uploads/ 目录下
                $info = $file->move('../uploads');
                if ($info) {
                    // 输出 42a79759f284b767dfcb2a0197904287.jpg
                    return json(Result::success($info->getFilename()));
                } else {
                    // 上传失败获取错误信息
                    return json(Result::success($file->getError()));
                }
            }
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }
}