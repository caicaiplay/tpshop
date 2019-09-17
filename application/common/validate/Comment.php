<?php


namespace app\common\validate;

use think\Validate;

class Comment extends Validate
{
    // 规则
    protected $rule = [
        'content|输入内容' => 'require|max:500',
    ];

    // 评论验证场景
    public function sceneComm()
    {
        $this->only(['content']);
    }
}