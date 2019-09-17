<?php

namespace app\admin\controller;

class Home extends Base
{
    // 后台首页
    public function index()
    {
        return view();
    }

    // 退出登陆
    public function loginOut()
    {
        session(null);
        if (!session('?admin.id')) {
            $this->success('退出成功', 'admin/index/login');
        } else {
            $this->error('退出失败');
        }
    }
}
