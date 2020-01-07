<?php


namespace app\common\validate;


use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'username' => 'require|length:1,40|chsDash',
        'password' => 'require|length:6,20|graph',
        'token' => 'require'
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'username.length' => '用户名长度过长',
        'username.chsDash' => '只能是汉字、字母、数字和下划线_及破折号-',
        'password.require' => '密码不能为空',
        'password.length' => '密码长度过必须在６～２０之间',
        'password.graph' => '密码只能是可打印字符（空格除外）',
        'token.require' => 'token不能为空'
    ];

    public function sceneLogin()
    {
        return $this->only(['username','password']);
    }

    public function sceneToken()
    {
        return $this->only(['token']);
    }
}