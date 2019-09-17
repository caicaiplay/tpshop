<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function initialize()
    {
        if (session('?admin.id')) {
            $this->redirect('admin/home/index');
        }
    }

    //后台登录方法
    public function login()
    {
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
            ];
            $ret = model('Admin')->login($data);

            if ($ret == 1) {
                $this->success('登录成功!', 'admin/home/index');
            } else {
                $this->error($ret);
            }
        }

        return $this->view->fetch('login');
    }

    // 注册方法
    public function register()
    {
        // 判断是否为ajax 返回的数据
        if (request()->isAjax()) {
            $data = [
                'username' => input('post.username'),
                'password' => input('post.password'),
                'conpass' => input('post.conpass'),
                'nickname' => input('post.nickname'),
                'email' => input('post.email'),
            ];
            $ret = model('Admin')->register($data);
            if ($ret == 1) {
                $this->success('注册成功!','admin/index/login');
            } else {
                $this->error($ret);
            }
        }
        return $this->view->fetch('register');
    }

    // 忘记密码
    public function forget()
    {
        if (request()->isAjax()) {
            $data = [
                'email' => input('post.email'),
            ];
            $ret = model('Admin')->getCode($data);
            if (is_numeric($ret)) {
                session('code', $ret);
                $this->success('验证码已经发送,请查收');
            } else {
                $this->error($ret);
            }
        }
        return $this->view->fetch('forget');
    }

    // 重置密码
    public function reset()
    {
        if (request()->isAjax()) {
            $data = [
                'code' => input('post.code'),
                'email' => input('post.email'),
            ];
            $ret = model('Admin')->reset($data);
            if ($ret == 1) {
                session('email',$data['email']);
                $this->success('验证成功请修改密码', 'admin/index/updatePass');
            } else {
                $this->error($ret);
            }
        }
    }

    // 确认密码修改
    public function updatePass()
    {
        if (request()->isAjax()) {
            $data = [
                'password' => input('post.password'),
                'conpass'  => input('post.conpass'),
            ];
            $ret = model('Admin')->updatePass($data);
            if ($ret == 1) {
                $this->success('密码修改成功请牢记', 'admin/index/login');
            } else {
                $this->error($ret,'admin/index/forget');
            }
        }
        return view();
    }

}



