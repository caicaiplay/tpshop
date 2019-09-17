<?php

namespace app\admin\controller;

class Admin extends Base
{
    // 管理员添加
    public function add()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass'  => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email'    => input('post.email'),
                'status'   => input('post.status'),
                'is_super' => input('post.is_super'),
            ];
            $result = model('Admin')->add($data);
            if ($result == 1) {
                $this->success('添加成功', 'admin/admin/lister');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 管理员列表
    public function lister()
    {
        $admins = model('Admin')->order('is_super')->paginate(5);
        $viewInfo = [
            'admins' => $admins,
        ];
        $this->assign($viewInfo);
        return view();
    }

    // 删除管理
    public function del()
    {
        if (request()->isAjax()) {
            $info = model('Admin')->with('article')->find(input('post.id'));
            $result = $info->together('article')->delete();
            if ($result) {
                $this->success('删除成功!', 'admin/admin/lister');
            } else {
                $this->error('删除失败!');
            }
        }
    }

    // 编辑管理员
    public function edit()
    {
        $adminInfo = model('Admin')->find(input('id'));
        $viewInfo = [
            'adminInfo' => $adminInfo,
        ];
        $this->assign($viewInfo);
        if (request()->isAjax()) {
            $data = [
                'id'       => input('post.id'),
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass'  => input('post.oldpass'),
                'nickname' => input('post.nickname'),
                'email'    => input('post.email'),
            ];
            $result = model('Admin')->edit($data);
            if ($result == 1) {
                $this->success('修改成功!', 'admin/admin/lister');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 启用禁用
    public function status()
    {
        if (request()->isAjax()) {
            $data = [
                'id' => input('post.id'),
                'status' => input('post.status') ? 0 : 1,
            ];
            $result = model('Admin')->status($data);
            if ($result == 1) {
                $this->success('操作成功!', 'admin/admin/lister');
            } else {
                $this->error($result);
            }
        }

    }
}
