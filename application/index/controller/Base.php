<?php


namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    // 视图共享
    public function initialize()
    {
        $cates = model('Cate')->order('sort', 'desc')->select();
        $topArticles = model('Article')->where('is_top',1)->order('create_time', 'desc')->limit(4)->select();
        $system = model('System')->find();
        $viewInfo = [
            'cates' => $cates,
            'system' => $system,
            'topArticles' => $topArticles,
        ];
        $this->view->share($viewInfo);
    }
}