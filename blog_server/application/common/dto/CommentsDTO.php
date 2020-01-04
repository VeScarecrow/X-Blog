<?php


namespace app\common\dto;


class CommentsDTO
{
    private $parent;
    private $childrenList;

    public function __construct($parent, $childrenList)
    {
        $this->parent = $parent;
        $this->childrenList = $childrenList;
    }

    public function toJson()
    {
        return array(
            'parent' => $this->parent,
            'childrenList' => $this->childrenList
        );
    }
}