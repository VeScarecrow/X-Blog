<?php


namespace app\admin\controller;


use app\common\dto\Result;
use app\common\model\User;
use think\Controller;
use think\Exception;
use app\common\validate\UserValidate;

/**
 * 用户验证接口
 * Class UserController
 * @package app\admin\controller
 */
class UserController extends Controller
{
    /**
     * 登陆
     * @return \think\response\Json
     */
    public function login()
    {
        try {
            $user = User::where(['username' => input('param.username'), 'password' => input('param.password')]);
            if ($user->count() != 0) {
                session('token', $user->find()->getAttr('username'));
                return json(Result::success(array(
                    'token' => session('token')
                ))->toJson());
            } else {
                return json(Result::loginError()->toJson());
            }
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    /**
     * 验证token
     * @param $token
     * @return \think\response\Json
     */
    public function getUserInfo($token)
    {
        try {
            $user = User::where(['username' => $token]);
            if ($user->count() == 1) {
                return json(Result::success(array(
                    'roles' => array('admin'),
                    'name' => $user->find()->getAttr('nickname'),
                    'avatar' => $user->find()->getAttr('avatar'),
                ))->toJson());
            }
            return json(Result::innerError()->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }


}