<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    use SoftDelete;

    protected $readonly = ['username', 'email']; // 设置只读字段

    // 修改器
    public function setPasswordAttr($value)
    {
        return sha1($value);
    }

    // 关联评论
    public function comments()
    {
        return $this->hasMany('Comment', 'member_id', 'id');
    }

    // 会员添加
    public function add($name)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('add')->check($name)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($name);
        if ($result) {
            return 1;
        } else {
            return '添加失败';
        }
    }

    // 注册会员
    public function register($name)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('register')->check($name)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($name);
        if ($result) {
            return 1;
        } else {
            return '注册失败';
        }
    }

    // 会员编辑
    public function edit($data)
    {
        $validate = new \app\common\validate\Member;
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $memberInfo = $this->find($data['id']);
        if ($data['oldpass'] != $memberInfo['password']) {
            return '原密码输入不正确!';
        }
        $memberInfo->password = $data['password'];
        $memberInfo->nickname = $data['nickname'];
        $result = $memberInfo->save();
        if ($result) {
            return 1;
        } else {
            return '更新失败';
        }
    }

    // 用户登录
    public function login($data)
    {
        $validate = new \app\common\validate\Member;
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        unset($data['verify']);
        $data['password'] = sha1($data['password']);
        $result = $this->where($data)->find();
        if ($result) {
            $sessionInfo = [
                'id' => $result['id'],
                'nickname' => $result['nickname'],
            ];
            session('member',$sessionInfo);
            return 1;
        } else {
            return '用户名或密码错误!';
        }

    }

}
