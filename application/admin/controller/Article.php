<?php

namespace app\admin\controller;

use think\facade\Session;

class Article extends Base
{
    // 文章添加
    public function add()
    {
        $cates = model('Cate')->select();
        $viewInfo = [
            'cates' => $cates
        ];
        $this->assign($viewInfo);
        //
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'desc' => input('post.desc'),
                'tags' => input('post.tags'),
                'content' => input('post.content'),
                'admin_id' => Session::get('admin.id'),
                'is_top' => input('post.is_top'),
                'cate_id' => input('post.cateid'),
            ];
            $result = model('Article')->add($data);
            if ($result == 1) {
                $this->success('文章添加成功!','admin/article/add');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 文章编辑列表
    public function lister()
    {
        $articles = model('Article')->with('cate,admin')
            ->order(['is_top' => 'asc', 'create_time' => 'desc'])
            ->paginate(5);
        $viewInfo = [
            'articles' => $articles,
        ];
        $this->assign($viewInfo);
        return view();
    }

    // 文章置顶
    public function top()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'is_top' => input('post.is_top')? 0 : 1,
            ];
            $result = model('Article')->top($data);
            if ($result == 1) {
                $this->success('操作成功!', 'admin/article/lister');
            } else {
                $this->error($result);
            }
        }
    }

    // 文章编辑
    public function edit()
    {
        $editInfo = model('Article')->find(input('id'));
        $cates = model('Cate')->select();
        $viewInfo = [
            'editInfo' => $editInfo,
            'cates'    => $cates,
        ];
        $this->assign($viewInfo);
        if (request()->isAjax()) {
            $data = [
                'title' => input('post.title'),
                'desc' => input('post.desc'),
                'tags' => input('post.tags'),
                'content' => input('post.content'),
                'is_top' => input('post.is_top'),
                'cate_id' => input('post.cateid'),
                'id'   => input('post.id'),
            ];
            $result = model('Article')->edit($data);
            if ($result == 1) {
                $this->success('文章修改成功!','admin/article/lister');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 删除
    public function del()
    {
        if (request()->isAjax()) {
            $result = model('Article')->with('comments')->find(input('post.id'));
            $delInfo = $result->together('comments')->delete();
            if ($delInfo) {
                $this->success('删除成功!','admin/article/lister');
            } else {
                $this->error('删除失败');
            }
        }
    }
}
