<?php


namespace app\admin\controller;


use app\common\dto\CommentsDTO;
use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Category;
use app\common\model\Comments;
use app\common\model\Links;
use think\Controller;
use think\Db;

class CommentsController extends Controller
{
    public function findAll()
    {
        try {
            $list = Comments::limit(8)->select();
            return json(Result::success($list)->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function findByPage($pageCode = 1, $pageSize = 10)
    {
        try {
            $list = model('common/Comments')->paginate($pageSize, false, ['page' => $pageCode]);
            $pageBean = new PageBean($list->total(), $list->items());
            return json(Result::success($pageBean->toJson())->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function save()
    {
        try {
            Comments::create(input('post.'))->allowField(true);
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function findCommentsList($articleId, $sort = 0, $pageCode = 1, $pageSize = 10)
    {
        try {
            Db::startTrans();
            //查询该文章的所有父级留言信息
            $page = Comments::where([
                'p_id' => 0,
                'c_id' => 0,
                'article_id' => $articleId,
                'sort' => $sort
            ])->paginate($pageSize, false, ['page' => $pageCode]);
            //查询该文章的所有留言信息
            $list = Comments::where([
                'article_id' => $articleId,
                'sort' => $sort
            ])->select();
            $commentsDTOS = array();
            foreach ($list as $comments) {
                //顶级留言
                if ($comments->p_id == 0 && $comments->c_id == 0) {
                    $commentsList = array();
                    foreach ($list as $item) {
                        //查找子级留言
                        if ($item->p_id != 0 && $item->p_id == $comments->id) {
                            array_push($commentsList, $item);
                        }
                    }
                    $commentsDTO = new CommentsDTO($comments, $commentsList);
                    array_push($commentsDTOS, $commentsDTO->toJson());
                }
            }
            $total = ceil($page->total()/$pageSize);
            Db::commit();
            //最后一页无数据残留的问题
            if ($total < ($pageCode * $pageSize - 1)) {
                $pageBean = new PageBean($total, array_slice($commentsDTOS, ($pageCode - 1) * $pageSize));
            } else {
                $pageBean = new PageBean($total, array_slice($commentsDTOS, ($pageCode - 1) * $pageSize, $pageSize));
            }
            return json(Result::success($pageBean->toJson())->toJson());
        } catch (\Exception $e) {
            Db::rollback();
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
            Comments::destroy($ids);
            Db::commit();
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }


}