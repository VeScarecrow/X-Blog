<?php


namespace app\common\validate;


use think\Validate;

class TagsValidate extends Validate
{
    protected $rule = [
        "pageCode" => "number|>=:1",
        "pageSize" => "number|>=:1",
        "name" => "require|length:1,40",
        "id" => "require|number",
        "ids" => "require",
    ];

    protected $message = [
        "pageCode.number" => "传入页面号不是number类型",
        "pageSize.number" => "传入页面大小不是number类型",
        "pageCode.>=" => "页面号小于１",
        "pageSize.>=" => "页面大小于１",
        "name.require" => "名字不能为空",
        "name.length" => "名字长度超出范围",
        "id.require" => "id不能为空",
        "id.number" => "传入id不是number类型",
        "ids.require" => "传入id数组为空为空",
    ];

    public function sceneFindByPage()
    {
        return $this->only(['pageCode','pageSize']);
    }

    public function sceneName()
    {
        return $this->only(['name']);
    }

    public function sceneUpdate()
    {
        return $this->only(['name','id']);
    }

    public function sceneIds()
    {
        return $this->only(['ids']);
    }

}