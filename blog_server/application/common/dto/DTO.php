<?php


namespace app\common\dto;


class DTO
{
    protected function toJSON($obj)
    {
        if (!is_object($obj)) return null;
        $vars = get_object_vars($obj);
        $arr = array();
        foreach ($vars as $k => $v) {
            $arr[$k] = $v;
        }
        return $arr;
    }
}