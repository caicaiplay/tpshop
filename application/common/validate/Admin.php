<?php


namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    // 验证规则
    protected $rule = [
        'username|管理员帐号' => 'require|max:25|chsDash',
        'password|密码' => 'require|length:3,40|alphaDash',
        'conpass|确认密码' => 'require|confirm:password',
        'email|邮箱' => 'require|email',
        'nickname|昵称' =>'require|chsDash|max:30',
        'code|验证码' => 'require|length:4',
    ];

    // 登录验证场景
    public function sceneLogin()
    {
        return $this->only(['username', 'password']);
    }

    // 注册场景验证
    public function sceneRegister()
    {
        return $this->only(['username', 'password', 'conpass', 'email', 'nickname'])
            ->append(['username' =>'unique:admin', 'email' => 'unique:admin']);
    }

    // 忘记密码验证场景
    public function sceneForget()
    {
        return $this->only(['email']);
    }

    // 验证码校验场景
    public function sceneReset()
    {
        return $this->only(['code']);
    }

    // 新密码验证场景
    public function sceneUpdatePass()
    {
        return $this->only(['password','conpass']);
    }

    // 修改场景验证
    public function sceneEdit()
    {
        return $this->only(['username', 'password', 'email', 'nickname'])
            ->append(['username' =>'unique:admin', 'email' => 'unique:admin']);
    }
}