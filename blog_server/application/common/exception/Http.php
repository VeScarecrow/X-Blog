<?php

namespace app\common\exception;

use app\common\dto\Result;
use Exception;
use InvalidArgumentException;
use JsonException;
use think\Db;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;

/**
 * Class Http 异常处理接管
 * @package app\common\exception
 */
class Http extends Handle
{
    public function render(Exception $e)
    {
//        json解析错误(api传参格式错误)
        if ($e instanceof JsonException) {
            Db::rollback();
            return json(Result::parError());
        }

        // 参数验证错误
        if ($e instanceof ValidateException) {
            Db::rollback();
            return json($e->getError(), 422);
        }

        //方法参数错误(无参数或无效参数)
        if ($e instanceof InvalidArgumentException) {
            Db::rollback();
            return json($e->getMessage(), 422);
        }

        // 请求异常
        if ($e instanceof HttpException && request()->isAjax()) {
            Db::rollback();
            return response($e->getMessage(), $e->getStatusCode());
        }

        // 其他错误交给系统处理
        return parent::render($e);
    }
}