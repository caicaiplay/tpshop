<?php

namespace app\admin\controller;

class Member extends Base
{
    // 会员添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'nickname' => input('post.nickname'),
                'email'    => input('post.email'),
            ];
            $result = model('Member')->add($data);
            if ($result == 1){
                $this->success('添加成功', 'admin/member/lister');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 会员列表
    public function lister()
    {
        $memberInfo = model('Member')->order(['create_time' => 'desc'])->paginate(5);
        $viewInfo = [
            'memberInfo' => $memberInfo,
        ];
        $this->assign($viewInfo);
        return view();
    }

    // 会员编辑
    public function edit()
    {
        $memberInfo = model('Member')->find(input('id'));
        $viweInfo = [
            'memberInfo' => $memberInfo,
        ];
        $this->assign($viweInfo);
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'oldpass' => input('post.oldpass'),
                'nickname' => input('post.nickname'),
                'email'    => input('post.email'),
                'id'  => input('post.id')
            ];
            $result = model('Member')->edit($data);
            if ($result == 1) {
                $this->success('更改成功!', 'admin/member/lister');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 会员删除
    public function del()
    {
        $info = model('Member')->with('comments')->find(input('post.id'));
        $result = $info->together('comments')->delete();
        if ($result) {
            $this->success('删除成功!','admin/member/lister');
        } else {
            $this->error('删除失败');
        }
    }
}
