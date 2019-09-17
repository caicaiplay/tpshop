<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;
use app\facade\Admin as Vadmin;
class Admin extends Model
{
    // 模型设置
    protected $pk = 'id';
    protected $table = 'tp_admin';

    //软删除
    use SoftDelete;

    // 密码修改器
    public function setPasswordAttr($value)
    {
        return sha1($value);
    }

    // 关联文章表
    public function article()
    {
        return $this->hasMany('Article','admin_id','id');
    }

    // 登录校验
    public function login($data)
    {
        if (!Vadmin::scene('login')->check($data)) {
            return Vadmin::getError();
        }
        $ret = $this->where('username', $data['username'])
            ->where('password', sha1($data['password']))
            ->find();
        if ($ret) {
            if ($ret['status'] != 1) {
                return '帐号被禁用';
            }
            $sessionDate = [
                'id' => $ret['id'],
                'nickname' => $ret['nickname'],
                'is_super' => $ret['is_super'],
            ];
            session('admin', $sessionDate);

            // 1 表示有这个用户
            return 1;
        } else {
            // 0 表示没有查询到
            return '用户名或者密码错误!';
        }
    }

    // 注册帐号
    public function register($data)
    {
        if (!Vadmin::scene('Register')->check($data)) {
            return Vadmin::getError();
        }
        $ret = $this->allowField(true)->save($data);
        if ($ret) {
            mailTo($data['email'], '注册成功通知', '恭喜您注册管理员账户成功!');
            return 1;
        } else {
            return '注册失败,请重新注册!';
        }
    }

    // 忘记密码
    public function getCode($data)
    {
        if (!Vadmin::scene('Forget')->check($data)) {
            return Vadmin::getError();
        }
        $ret = $this->where($data)->find();
        if ($ret) {
            $code = mt_rand(1000,9999); // 生成四位验证码
            mailTo($data['email'], '重置密码验证码', '你的重置密码的验证码为:'.$code);
            return $code;
        } else {
            return '该邮箱没有注册!';
        }
    }

    // 验证码验证
    public function reset($data) {
        if (!Vadmin::scene('Reset')->check($data)) {
            return Vadmin::getError();
        }
        if ($data['code'] == session('code')) {
            return 1;
        } else {
            return '验证码输入不正确,请重新输入!';
        }
    }

    // 重置密码
    public function updatePass($data) {
        if (!Vadmin::scene('updatepass')->check($data)) {
            return Vadmin::getError();
        }
        $ret = $this->where('email', session('email'))->find();
        if ($ret) {
            $ret->password = $data['password'];
            $ret->save();
            session('email', null);
            return 1;
        } else {
            return '请先输入邮箱!';
        }
    }

    // 添加管理员
    public function add($data)
    {
        if (!Vadmin::scene('Register')->check($data)) {
            return Vadmin::getError();
        }
        $ret = $this->allowField(true)->save($data);
        if ($ret) {
            return 1;
        } else {
            return "添加失败";
        }
    }

    // 修改资料
    public function edit($data)
    {
        if (!Vadmin::scene('edit')->check($data)) {
            return Vadmin::getError();
        }
        $result = $this->find($data['id']);
        if ($result['password'] != $data['conpass']) {
            return '原密码不正确!';
        }
        $result->username = $data['username'];
        $result->password = $data['password'];
        $result->email = $data['email'];
        $result->nickname = $data['nickname'];
        $sessionDate = [
            'id' => $data['id'],
            'nickname' => $data['nickname'],
            'is_super' => $result['is_super'],
        ];
        session('admin', $sessionDate);
        $retInfo = $result->save();
        if ($retInfo) {
            return 1;
        } else {
            return '修改失败!';
        }
    }

    // 禁用启用状态
    public function status($data)
    {
        $result = $this->find($data['id']);
        $result->status = $data['status'];
        $ret = $result->save();
        if ($ret) {
            return 1;
        } else {
            return '操作失败';
        }
    }

}
