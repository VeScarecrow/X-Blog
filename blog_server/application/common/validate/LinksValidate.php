<?php


namespace app\common\validate;


use think\Validate;

class LinksValidate extends Validate
{
    protected $rule = [
        "ids" => "require",
        "name" => "require|length:1,40",
        "url" => "require|url",
    ];

    protected $message = [
        "ids.require" => "传入id数组为空",
        "name.require" => "名字不能为空",
        "name.length" => "名字长度超出范围",
        "url.require" => "url不能为空",
        "url.url" => "url不是有效的url格式",
    ];


    public function sceneIds()
    {
        return $this->only(['ids']);
    }

    public function sceneSave()
    {
        return $this->only(['name','url']);
    }

}