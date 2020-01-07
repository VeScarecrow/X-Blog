<?php

namespace app\common\model;

use think\Model;

class Tags extends Model
{
    //
    public function article()
    {
        return $this->belongsToMany('Article', 'article_tags', 'article_id', 'tags_id');
    }
}
