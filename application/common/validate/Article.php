<?php


namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title|标题' => 'require',
        'desc|描述' => 'require',
        'tags|标签' => 'require',
        'content|内容' => 'require',
        'is_top|置顶' => 'require',
        'id|文章ID' => 'require|number',
        'cate_id|所属模块' => 'require',
    ];

    // 添加场景
    public function sceneAdd()
    {
        return $this->only(['title', 'desc', 'tags', 'content', 'is_top', 'cate_id']);
    }

    // 文章置顶
    public function sceneTop()
    {
        return $this->only(['id', 'is_top']);
    }

    // 文章修改
    public function sceneEdit()
    {
        return $this->only(['title', 'desc', 'tags', 'content', 'is_top', 'cate_id']);
    }
}