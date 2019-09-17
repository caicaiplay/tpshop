<?php
namespace app\index\controller;

class Index extends Base
{
    // 主页渲染
    public function index()
    {
        $where = [];
        $catename = null;
        if (input('?id')) {
            $where = [
                'cate_id' => input('id'),
            ];
            $catename = model('Cate')->where('id',input('id'))->value('catename');
        }
        $articles = model('Article')->where($where)->field('content',true)
            ->with('admin')->order('create_time','desc')
            ->paginate(4,false, ['query' => $where]);
        $viewInfo = [
            'articles' => $articles,
            'catename' => $catename,
        ];
        $this->assign($viewInfo);
        return view();
    }

    // 注册用户
    public function register()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass'  => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email'    => input('post.email'),
                'verify'   => input('post.verify')
            ];
            $result = model('Member')->register($data);
            if ($result == 1) {
                $this->success('注册成功!', 'index/index/login');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 登录用户
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'verify'   => input('post.verify'),
            ];
            $result = model('Member')->login($data);
            if ($result == 1) {
                $this->success('登录成功','index/index/index');
            } else {
                $this->error($result);
            }
        }
        return view();
    }

    // 用户登出
    public function loginOut()
    {
        if (request()->isAjax()) {
            session(null);
            if (!session('?member.id')) {
                $this->success('退出成功','index/index/index');
            } else {
                $this->error('退出失败');
            }
        }
    }

    // 搜索
    public function search()
    {
        $where[] = ['title', 'like', '%'.input('search').'%'];
        $result = model('Article')->where($where)->order('create_time', 'desc')->paginate(5);
        if ($result) {
            $viewInfo = [
                'articles' => $result,
                'catename' => input('search'),
            ];
        }
        $this->assign($viewInfo);
        return view('index');
    }
}



