<?php


namespace app\admin\controller;


use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Article;
use app\common\model\Category;
use think\Controller;
use think\Db;
use app\common\validate\CategoryValidate;

/**
 * 文章分类管理接口
 * Class CategoryController
 * @package app\admin\controller
 */
class CategoryController extends Controller
{

    /**
     * 分页查询
     * @param int $pageCode 页码
     * @param int $pageSize 每页数量
     * @return \think\response\Json
     */
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

    /**
     * 通过id删除
     * @return \think\response\Json
     */
    public function deleteById()
    {
        try {
            $ids = input('post.');
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

    /**
     * 新增
     * @return \think\response\Json
     */
    public function save()
    {

        try {
            $name = input('post.name');
            if (Category::where('name', 'like', $name)->count() == 0) {
                Category::create(['name' => $name]);
                return json(Result::success()->toJson());
            }
            return json(Result::repError()->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    /**
     * 更新
     * @return \think\response\Json
     */
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

    /**
     * 通过标题查找
     * @param string $title
     * @return \think\response\Json
     */
    public function findByName($title = '')
    {
        try {
            $list = Category::where('name', 'like', '%' . $title . '%')->limit(30)->select();
            $name_arr = array();
            foreach ($list as $item) {
                array_push($name_arr, $item->name);
            }
            return json(Result::success($name_arr)->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

}