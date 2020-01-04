<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    //
    public function article()
    {
        return $this->belongsToMany('Article', 'article_category', 'article_id', 'category_id');
    }

}
