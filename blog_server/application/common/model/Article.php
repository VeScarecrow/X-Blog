<?php


namespace app\common\model;


use think\db\Query;
use think\Model;

class Article extends Model
{
    /**
     * test 自动完成
     */
    protected $insert = [
        'title' => 'x',
        'title_pic' => 'x',
        'author' => 'x',
        'content' => 'x',
        'content_md' => 'x',
        'origin' => 'x',
        'state' => '0',
        'eye_count' => 100,
    ];

    /**
     * @var array 指定类型转换
     */
//    protected $type = [
//        'publish_time'  =>  'timestamp',
//        'edit_time'  =>  'timestamp',
//        'create_time'  =>  'timestamp'
//    ];

    /**
     * 开启自动时间戳
     */
//    protected $autoWriteTimestamp = true;
//    protected $updateTime = 'edit_time';

    public function category()
    {
        return $this->belongsToMany('Category', 'article_category', 'category_id', 'article_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Tags', 'article_tags', 'tags_id', 'article_id');
    }

    public function comments()
    {
        return $this->hasMany('Comments', 'article_id', 'id');
    }

    public function searchTitleAttr($query, $value, $data)
    {
        $query->where('title', 'like', '%' . $value . '%')->limit(50);
    }

    public function getCategoryAttr($value, $data)
    {
        if (count($value, 0) > 0) {
            return $value[0]['name'];
        }
        return "";
    }

    public function getTagsAttr($value, $data)
    {
        $tagsString = array();
        foreach ($value as $tag) {
            array_push($tagsString, $tag['name']);
        }
        return json_encode($tagsString);
    }


    public function getStateAttr($value, $data)
    {
        $stateText = ['0' => 'deleted', '1' => 'draft', '2' => 'published'];
        return $stateText[$value];
    }

    public function setStateAttr($value, $data)
    {
        $stateText = ['deleted' => '0', 'draft' => '1', 'published' => '2'];
        return $stateText['published'];
    }

    //date('Y-m-d H:i:s', 1502204401)
    public function setPublishTimeAttr($value, $data)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function setEditTimeAttr($value, $data)
    {
        return date('Y-m-d H:i:s', $value);
    }
}