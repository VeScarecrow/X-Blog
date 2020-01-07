<?php


namespace app\admin\controller;


use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Category;
use app\common\model\Links;
use app\common\model\Tags;
use think\Controller;
use think\Db;

/**
 * 标签管理接口
 * Class TagsController
 * @package app\admin\controller
 */
class TagsController extends Controller
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
            $list = model('common/Tags')->paginate($pageSize, false, ['page' => $pageCode]);
            $pageBean = new PageBean($list->total(), $list->items());
            return json(Result::success($pageBean->toJson())->toJson());
        } catch (\Exception $e) {
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
            if (Tags::where('name', 'like', $name)->count() == 0) {
                Tags::create(['name' => $name]);
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
            if (Tags::where('name', 'like', $name)->count() == 0) {
                Tags::update(['name' => $name], ['id' => input('post.id')])->isUpdate(true)->allowField(true);
                return json(Result::success()->toJson());
            }
            return json(Result::repError());
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
            Tags::destroy($ids);
            Db::commit();
            return json(Result::success($ids)->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }


}