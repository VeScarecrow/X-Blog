<?php


namespace app\admin\controller;


use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Category;
use app\common\model\Links;
use think\Controller;
use think\Db;

/**
 * 链接管理接口
 * Class LinksController
 * @package app\admin\controller
 */
class LinksController extends Controller
{
    /**
     * 有限查询
     * @return \think\response\Json
     */
    public function findAll()
    {
        try {
            $list = Links::limit(50)->select();
            return json(Result::success($list)->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    /**
     * 分页查询
     * @param int $pageCode 页码
     * @param int $pageSize 每页数量
     * @return \think\response\Json
     */
    public function findByPage($pageCode = 1, $pageSize = 10)
    {
        try {
            $list = Links::where('1=1')->paginate($pageSize, false, ['page' => $pageCode]);
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
            Links::destroy($ids);
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
            Links::create(['name' => input('post.name'), 'url' => input('post.url')]);
            return json(Result::success()->toJson());
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
            Links::update(input('post.'));
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

}