<?php


namespace app\common\validate;

use think\Validate;

class Member extends Validate
{
    // 验证规则
    protected $rule = [
        'username|会员帐号' => 'require|max:25|chsDash|unique:member',
        'oldpass|原密码' => 'require|length:3,40|alphaDash',
        'password|密码' => 'require|length:1,25|alphaDash',
        'conpass|确认密码' => 'require|confirm:password',
        'nickname|昵称' =>'require|chsDash|max:30',
        'email|邮箱' => 'require|email|unique:member',
        'verify|验证码' => 'require|captcha'
    ];

    // 添加验证场景
    public function sceneAdd()
    {
        return $this->only(['username', 'password', 'nickname', 'email']);
    }

    // 编辑验证场景
    public function sceneEdit()
    {
        return $this->only(['oldpass', 'password', 'nickname']);
    }

    // 注册场景
    public function sceneRegister()
    {
        return $this->only(['username', 'password', 'conpass', 'nickname', 'email', 'verify']);
    }

    public function sceneLogin()
    {
        return $this->only(['username', 'password', 'verify'])->remove(['username' => 'unique']);
    }
}