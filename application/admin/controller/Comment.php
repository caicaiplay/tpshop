<?php

namespace app\admin\controller;

class Comment extends Base
{
    // 评论列表
    public function lists()
    {
        $comments = model('Comment')->with('article,member')->order('create_time', 'desc')->paginate(3);
        $viewInfo = [
            'comments' => $comments,
        ];
        $this->assign($viewInfo);
        return view();
    }

    // 评论删除
    public function del()
    {
        if (request()->isAjax()) {
            $res = model('Comment')->find(input('post.id'));
            $art = model('Article')
                ->field('content,title,desc,tags',true)
                ->find($res['article_id']);
            if ($art['com_num'] > 0) {
                $art->setDec('com_num');
            }
            $result = $res->delete();
            if ($result) {
                $this->success('删除成功', 'admin/comment/lists');
            } else {
                $this->error('删除失败');
            }
        }
    }
}
