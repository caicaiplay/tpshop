<?php

namespace app\admin\controller;

class Cate extends Base
{
    // 栏目列表
    public function lister()
    {
        $cates = model('Cate')->order(['sort' => 'asc'])->paginate(3);
        $viewData = [
            'cates' => $cates,
        ];
        $this->assign($viewData);
        return $this->fetch();
    }

    // 栏目添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'catename' => input('post.catename'),
                'sort' => input('post.sortname'),
            ];
            $result = model('Cate')->add($data);
            if ($result == 1) {
                $this->success('添加成功', 'admin/cate/lister');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 栏目排序
    public function sort()
    {
        $data = [
            'id' => input('post.id'),
            'sort' => input('post.sort'),
        ];
        $result = model('Cate')->sort($data);
        if ($result == 1) {
            $this->success('排序成功', 'admin/cate/lister');
        } else {
            $this->error($result);
        }
    }

    // 栏目编辑
    public function edit()
    {
        $cateInfo = model('Cate')->find(input('id'));
        $veiwInfo = [
            'cateInfo' => $cateInfo,
        ];
        $this->assign($veiwInfo);
        return view();
    }

    // 栏目信息更新
    public function update()
    {
        if (request()->isAjax()) {
            $data = [
                'catename' => input('post.catename'),
                'id'       => input('post.id'),
            ];
            $result = model('Cate')->updateCate($data);
            if ($result == 1) {
                $this->success('编辑成功', 'admin/cate/lister');
            } else {
                $this->error($result);
            }
        }
    }

    // 删除栏目
    public function del()
    {
        if (request()->isAjax()) {
            $cateInfo = model('Cate')->with('article,article.comments')->find(input('post.id'));
            foreach ($cateInfo['article'] as $k => $v) {
                $v->together('comments')->delete();
            }
            $result = $cateInfo->together('article')->delete();
            if ($result) {
                $this->success('删除成功', 'admin/cate/lister');
            } else {
                $this->error('删除失败');
            }
        }
    }
}
