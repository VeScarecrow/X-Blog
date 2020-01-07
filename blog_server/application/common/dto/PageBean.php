<?php


namespace app\common\dto;


class PageBean
{
    private $total;
    private $rows = array();

    public function __construct($total, $rows)
    {
        $this->total = $total;
        $this->rows = $rows;
    }

    public function toJson()
    {
        return array(
            'total' => $this->total,
            'rows' => $this->rows
        );
    }
}