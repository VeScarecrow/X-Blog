<?php


namespace app\common\dto;

/**
 * Class Result 封装api的返回数据
 * @package app\common\dto
 */
class Result
{
    private $code;
    private $data;
    private $token;

    public function __construct($code, $data)
    {
        $this->code = $code;
        $this->data = $data;
    }

    public function toJWT($code, $token)
    {
        $this->code = $code;
        $this->token = $token;
    }

    public function toJson()
    {
        return array(
            'code' => $this->code,
            'data' => $this->data
        );
    }

    public static function success($data = 'DEFAULT')
    {
        if ($data === 'DEFAULT') {
            return new Result(StatusCode::SUCCESS, "操作成功");
        } else {
            return new Result(StatusCode::SUCCESS, $data);
        }
    }

    public static function innerError()
    {
        return new Result(StatusCode::INNER_ERROR, "系统异常");
    }

    public static function parError()
    {
        return new Result(StatusCode::PARAMETER_ERROR, "参数错误");
    }

    public static function loginError()
    {
        return new Result(StatusCode::LOGINE_ERROR, "用户名或密码错误");
    }

    public static function pwdCheckError()
    {
        return new Result(StatusCode::LOGINE_ERROR, "输入的旧密码不匹配");
    }

    public static function unknownUserError()
    {
        return new Result(StatusCode::LOGINE_ERROR, "用户不存在");
    }

    public static function methodError()
    {
        return new Result(StatusCode::METHOD_ERROR, "方法不允许");
    }

    public static function repError()
    {
        return new Result(StatusCode::REPEAT_ERROR, "参数|操作 重复");
    }
}