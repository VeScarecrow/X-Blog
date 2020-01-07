<?php


namespace app\common\dto;


class ArticleArchivesDTO
{
    private $date;
    private $articles = array();


    public function __construct($date, $articles)
    {
        $this->date = $date;
        $this->articles = $articles;
    }


    function toJSON(){
        return array(
            'date' => $this->date,
            'articles' => $this->articles
        );
    }
}