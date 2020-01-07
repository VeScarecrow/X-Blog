<?php


namespace app\common\dto;

/**
 * Class StatusCode 封装api返回数据的状态码
 * @package app\common\dto
 */
class StatusCode
{
    const SUCCESS = 20000; //成功
    const INNER_ERROR = 20001; //系统错误
    const LOGINE_ERROR = 20002; //用户名或密码错误
    const ACCESS_ERROR = 20003; //权限不足
    const REPEAT_ERROR = 20004; //重复操作
    const PARAMETER_ERROR = 20005; //参数错误
    const METHOD_ERROR = 20006; //方法错误
}