<?php


namespace app\admin\controller;


use app\common\dto\ArticleArchivesDTO;
use app\common\dto\PageBean;
use app\common\dto\Result;
use app\common\model\Category;
use app\common\model\Tags;
use think\Controller;
use app\common\model\Article;
use think\Db;
use think\model\Collection;
use app\common\validate\ArticleValidate;

/**
 * Class ArticleController 文章管理接口
 * @package app\admin\controller
 */
class ArticleController extends Controller
{
    public function findCountByArticleId($article_id)
    {
        $data['article_id'] = $article_id;
        $validate = new ArticleValidate;
        try {
            $article = Article::get($article_id);
            return json(Result::success($article->comments->count())->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }

    public function findAll()
    {
        try {
            return json(Result::success(Article::order('publish_time desc')->limit(8)->select())->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function findAllCount()
    {
        try {
            return json(Result::success(Article::count('id'))->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }


    public function findByPage($pageCode = 1, $pageSize = 10)
    {

        try {
            if (input('?param.beginTime') && input('?param.endTime')) {
                $list = Article::whereRaw("publish_time between :st and :ed", ['st' => input('param.beginTime'), 'ed' => input('param.endTime')])
                    ->paginate($pageSize, false, ['page' => $pageCode]);
            } else {
                $list = model('common/Article')->paginate($pageSize, false, ['page' => $pageCode]);
            }
            $bind_list = $this->toFrontArr($list->items());
            $pageBean = new PageBean($list->total(), $bind_list);
            return json(Result::success($pageBean->toJson())->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    public function findById($id)
    {
        try {
            $item = Article::get($id);
            return json(Result::success($this->toFrontArr($item))->toJson());
        } catch (\Exception $e) {
            return json(Result::innerError()->toJson());
        }
    }

    /**
     * @param string $title 前台api
     * @return \think\response\Json
     */
    public function search($title)
    {
        try {
            $list = model('common/Article')->withSearch(['title'], [
                'title' => $title,
                'state' => '2'
            ])->select();
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
            foreach ($ids as $id) {
                $article = Article::find($id);
                if ($article == null) continue;
                $article->category()->detach();
                $article->tags()->detach();
                $article->delete();
            }
            Db::commit();
            return json(Result::success()->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }

    public function findArchives()
    {
        try {
            Db::startTrans();
            $archives_all = Article::orderRaw('DATE_FORMAT(publish_time, \'%Y-%m\') DESC')->distinct('DATE_FORMAT(publish_time, \'%Y-%m\')')->fieldRaw('DATE_FORMAT(publish_time, \'%Y-%m\') time')->limit(100)->select();
            $archive_articles = array();
            foreach ($archives_all as $date) {
                $archive = Article::field('id, title, publish_time')->whereLike('publish_time', '%' . $date['time'] . '%')->select();
                $articles = array();
                foreach ($archive as $item) {
                    array_push($articles, [
                        'id' => $item->id,
                        'title' => $item->title,
                        'publish_time' => $item->publish_time
                    ]);
                }
                $archive_article = new ArticleArchivesDTO($date['time'], $articles);
                array_push($archive_articles, $archive_article->toJSON());
            }
            Db::commit();
            return json(Result::success($archive_articles)->toJson());
        } catch (\Exception $e) {
            Db::rollback();
            return json(Result::innerError()->toJson());
        }
    }

    public function save()
    {
        return $this->updateArticleCategoryTags('save');
    }

    public function update()
    {
        return $this->updateArticleCategoryTags('update');
    }

    /**
     * 模型/数据集转换json
     * @param mixed $data 数据
     * @return array 数组
     */
    public function toFrontArr($data)
    {
        //判断是数据集 or 模型对象
        if ($data instanceof Collection || is_array($data)) {
            $new_arr = array();
            foreach ($data as $item) {
                array_push($new_arr, array_merge(json_decode(json_encode($item), true), array(
                    'category' => $item->category,
                    'tags' => $item->tags
                )));
            }
            return $new_arr;
        } else {
            return array_merge(json_decode(json_encode($data), true), array(
                'category' => $data->category,
                'tags' => $data->tags
            ));
        }
    }

    /** 关联 C & U
     * @param string $method 传入方法名称 save/update
     * @return \think\response\Json json数据
     */
    public function updateArticleCategoryTags($method)
    {
        //        if (!request()->isAjax()) {
        //            return json(Result::methodError()->toJson());
        //        }
//        try {
            $input = input('post.');
            if (input('?post.state') && input('post.state') == 'published') {
                //发布时间
                $input['publish_time'] = time();
            }
            //编辑时间
            $input['edit_time'] = time();
            //开始事务
            Db::startTrans();
            if ($method == 'save') {
                $article = Article::create($input)->allowField(true);
            } else if ($method == 'update') {
                $article = Article::update($input)->allowField(true);
            } else {
                return json(Result::parError()->toJson());
            }
            if (input('?post.category')) {
                $category = input('post.category');
                if ($method == 'update') $article->category()->detach();
                $category_model = Category::where('name', 'like', $category);
                if ($category_model->count() == 0) {
                    $article->category()->save(['name' => $category]);
                } else {
                    $article->category()->save($category_model->find());
                }
            }
            if (input('?post.tags')) {
                $tags_arr = json_decode((input('post.tags')), true);
                if ($method == 'update') $article->tags()->detach();
                foreach (array_unique($tags_arr) as $item) {
                    $tags_model = Tags::where('name', 'like', $item);
                    if ($tags_model->count() == 0) {
                        $article->tags()->save(['name' => $item]);
                    } else {
                        $article->tags()->save($tags_model->find());
                    }
                }
            }
            Db::commit();
            return json(Result::success()->toJson());
//        } catch (\Exception $e) {
//            Db::rollback();
//            return json(Result::innerError()->toJson());
//        }
    }

}