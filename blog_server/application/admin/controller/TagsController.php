<?php


namespace app\admin\controller;


use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Category;
use app\common\model\Links;
use app\common\model\Tags;
use think\Controller;
use think\Db;
use app\common\validate\TagsValidate;

class TagsController extends Controller
{
    public function findByPage($pageCode = 1, $pageSize = 10)
    {
        try {
            $list = model('common/Tags')->paginate($pageSize, false, ['page' => $pageCode]);
            $pageBean = new PageBean($list->total(), $list->items());
            return json(Result::success($pageBean->toJson())->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function save()
    {
        try {
            $name = input('post.name');
            if (Tags::where('name', 'like', $name)->count() == 0) {
                Tags::create(['name' => $name]);
                return json(Result::success()->toJson());
            }
            return json(Result::repError());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function update()
    {
        try {
            $name = input('post.name');
            if (Tags::where('name', 'like', $name)->count() == 0) {
                Tags::update(['name' => $name], ['id' => input('post.id')])->isUpdate(true)->allowField(true);
                return json(Result::success()->toJson());
            }
            return json(Result::repError());
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
            Tags::destroy($ids);
            Db::commit();
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }


}