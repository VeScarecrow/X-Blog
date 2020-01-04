<?php


namespace app\admin\controller;


use app\common\dto\Result;
use app\common\model\Category;
use app\common\model\Links;
use think\Controller;
use think\Db;

class LinksController extends Controller
{
    public function findAll()
    {
        try {
            $list = Links::limit(50)->select();
            return json(Result::success($list)->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function deleteById()
    {
        try {
            $ids = input('post.ids');
            if (!is_array($ids)) {
                $ids = array($ids);
            }
            Db::startTrans();
            Links::destroy($ids);
            Db::commit();
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }

    public function save()
    {
        try {
            Links::create(['name' => input('post.name'), 'url' => input('post.url')]);
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }


}