<?php


namespace app\common\validate;


use think\Validate;


class CommentsValidate extends Validate
{
    protected $rule = [
        "pageCode" => "number|egt:1",
        "pageSize" => "number|egt:1",
        "ids" => "require",
        "id" => "number",
        "p_id" => "require|number",
        "c_id" => "require|number",
        "article_title" => "require|length:1,40",
        "article_id" => "require|number",
        "articleId" => "require|number",
        "author" => "require|length:1,40",
        "author_id" => "require|number",
        "email" => "require|email",
        "content" => "require|length:1,200",
        "time" => "require|date",
        "url" => "require|url",
        "state" => "require|min:1",
        "sort" => "require|number",
    ];

    protected $message = [

        "pageCode.number" => "传入页面号不是number类型",
        "pageSize.number" => "传入页面大小不是number类型",
        "pageCode.egt" => "页面号小于１",
        "pageSize.egt" => "页面大小小于１",
        "id.number" => "传入id不是number类型",
        "p_id.require" => "p_id不能为空",
        "p_id.number" => "传入p_id不是number类型",
        "c_id.require" => "c_id不能为空",
        "c_id.number" => "传入c_id不是number类型",
        "article_title.require" => "标题不能为空",
        "article_title.length" => "标题长度超出范围",
        "article_id.require" => "缺少博文ID参数",
        "article_id.number" => "博文ID不是number类型",
        "articleId.require" => "缺少博文ID参数",
        "articleId.number" => "博文ID不是number类型",
        "author.require" => "用户名不能为空",
        "author.length" => "用户名称长度只能在１～４０之间",
        "author_id.require" => "用户id不能为空",
        "author_id.number" => "用户id不是number类型",
        "email.require" => "email不能为空",
        "email.email" => "email格式错误",
        "content.require" => "评论内容不能为空",
        "content.length" => "评论内容长度超出范围",
        "time.require" => "评论时间不能为空",
        "time.date" => "评论时间格式错误",
        "url.require" => "url不能为空",
        "url.url" => "url不是有效的url格式",
        "state.require" => "state不能为空",
        "state.min" => "state字符串长度为０",
        "sort.require" => "sort不能为空",
        "sort.number" => "sort不是number类型",
        "ids.require" => "传入id数组为空",
    ];


    public function sceneFindByPage()
    {
        return $this->only(['pageCode','pageSize']);
    }

    public function sceneSave()
    {
        return $this->only(['id','p_id','c_id','article_title','article_id',
            'author','author_id','email','content','time','url','state','sort']);
    }

    public function sceneFindCommentsList()
    {
        return $this->only(['articleId','sort',"pageCode","pageSize"])
            ->remove('sort','require');
    }

    public function sceneIds()
    {
        return $this->only(['ids']);
    }

}