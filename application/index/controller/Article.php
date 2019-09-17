<?php


namespace app\index\controller;


class Article extends Base
{
    // 文章内容
    public function content()
    {
        $articleInfo = model('Article')
            ->where('id',input('id'))
            ->with('admin')     // with('admin,comments,comments.member')
            ->find();
        $comms = model('Comment')->where('article_id',input('id'))
            ->with('member')
            ->order('create_time','desc')->paginate(3);
        $articleInfo->setInc('read_num');
        $viewInfo = [
            'articleInfo' => $articleInfo,
            'comms'   => $comms,
        ];
        $this->assign($viewInfo);
        return view();
    }

    // 投稿
    public function contribute()
    {
        return view();
    }

    // 评论
    public function comment()
    {
        if (request()->isAjax()) {
            $data = [
                'content' => input('post.comment'),
                'article_id' => input('post.article_id'),
                'member_id'  => input('post.member_id'),
            ];
            $result = model('Comment')->add($data);
            if ($result == 1) {
               $commNum = model('article')->where('id',$data['article_id'])
                   ->find();
                $commNum->setInc('com_num');
                $this->success('评论成功!');
            } else {
                $this->success($result);
            }
        }
    }
}