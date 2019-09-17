<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    // 重复登录过滤 // 初始化
    public function initialize()
    {
        if (!session('?admin.id')) {
            $this->redirect('admin/index/login');
        }
    }
}
