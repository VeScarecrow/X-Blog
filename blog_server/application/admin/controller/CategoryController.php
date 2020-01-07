<?php


namespace app\admin\controller;


use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Article;
use app\common\model\Category;
use think\Controller;
use think\Db;
use app\common\validate\CategoryValidate;

class CategoryController extends Controller
{

    public function findByPage($pageCode = 1, $pageSize = 10)
    {
        try {
            $list = model('common/Category')->paginate($pageSize, false, ['page' => $pageCode]);
            $pageBean = new PageBean($list->total(), $list->items());
            return json(Result::success($pageBean->toJson())->toJson());
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
            foreach ($ids as $id) {
                $category = Category::find($id);
                if ($category == null) continue;
                $category->article()->detach();
                $category->delete();
            }
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
            $name = input('post.name');
            if (Category::where('name', 'like', $name)->count() == 0) {
                Category::create(['name' => $name]);
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
            if (Category::where('name', 'like', $name)->count() == 0) {
                Category::update(['name' => $name], ['id' => input('post.id')])->isUpdate(true)->allowField(true);
                return json(Result::success()->toJson());
            }
            return json(Result::repError());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }


}