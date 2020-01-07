<?php


namespace app\common\validate;


use think\Validate;

class ArticleValidate extends Validate
{

    protected $rule = [
        "article_id" => "require|number",
        "pageCode" => "number|>=:1",
        "pageSize" => "number|>=:1",
        "beginTime" => "date",
        "endTime" => "date|>=:beginTime",
        "title" => "require|length:1,40",
        "ids" => "require",
        "id" => "require|number",
        "data" => "require",
        "method" => "require",
        "state" => "min:1",
        "category" => "min:1"
    ];

    protected $message = [
        "article_id.require" => "缺少博文ID参数",
        "article_id.number" => "博文ID不是number类型",
        "pageCode.number" => "传入页面号不是number类型",
        "pageSize.number" => "传入页面大小不是number类型",
        "pageCode.>=" => "页面号小于１",
        "pageSize.>=" => "页面大小小于１",
        "beginTime.date" => "开始时间格式不对",
        "endTime.date" => "结束时间格式不对",
        "title.require" => "标题不能为空",
        "title.length" => "标题长度不符合规范",
        "ids.require" => "传入id数组为空为空",
        "id.require" => "id不能为空",
        "id.number" => "传入id不是number类型",
        "data.require" => "传入data为空",
        "method.require" => "传入操作方法method为空",
        "state.length" => "传入state字符串长度为０",
        "category.min" => "传入category字符串长度为０"
    ];

    public function sceneArticleId()
    {
        return $this->only(["article_id"]);
    }

    public function sceneFindByPage()
    {
        return $this->only(['pageCode','pageSize',"beginTime","endTime"]);
    }

    public function sceneId()
    {
        return $this->only(['id']);
    }

    public function sceneTitle()
    {
        return $this->only(['title']);
    }

    public function sceneIds()
    {
        return $this->only(['ids']);
    }

    public function sceneData()
    {
        return $this->only(['data']);
    }

    public function sceneUpdateArticleCategoryTags()
    {
        return $this->only(['method','state','category']);
    }
}