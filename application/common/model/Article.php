<?php

namespace app\common\model;

use think\Model;
use app\facade\Article as Art;
use think\model\concern\SoftDelete;

class Article extends Model
{
    use SoftDelete;

    // 关联栏目表
    public function cate()
    {
        return $this->belongsTo('Cate','cate_id', 'id');
    }

    // 关联管理员
    public function admin()
    {
        return $this->belongsTo('Admin','admin_id', 'id');
    }

    // 关联评论表
    public function comments()
    {
        return $this->hasMany('Comment', 'article_id', 'id');
    }

    // 文章添加
    public function add($data)
    {
        if (!Art::scene('add')->check($data)) {
            return Art::getError();
        }
        if ($data['admin_id'] == 0) {
            return '获取作者id失败';
        }
        $articleInfo = $this->allowField(true)->save($data);
        if ($articleInfo) {
            return 1;
        } else {
            return '添加失败!';
        }
    }

    // 文章置顶
    public function top($data)
    {
        if (!Art::scene('top')->check($data)) {
            return Art::getError();
        }
        $result = $this->find($data['id']);
        $result->is_top = $data['is_top'];
        $topInfo = $result->save();
        if ($topInfo) {
            return 1;
        } else {
            return "操作失败";
        }
    }

    // 文章修改
    public function edit($data)
    {
        if (!Art::scene('edit')->check($data)) {
            return Art::getError();
        }
        $result = $this->find($data['id']);
        $result->title = $data['title'];
        $result->desc = $data['desc'];
        $result->tags = $data['tags'];
        $result->content = $data['content'];
        $result->is_top = $data['is_top'];
        $result->cate_id = $data['cate_id'];
        $editInfo = $result->save();
        if ($editInfo) {
            return 1;
        } else {
            return '修改失败!';
        }
    }
}
