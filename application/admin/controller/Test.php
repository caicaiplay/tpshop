<?php


namespace app\admin\controller;


class Test extends Base
{
    // 测试
    public function test()
    {
        $cateInfo = model('Cate')->with('article,article.comments')->find(input('post.id'));
        halt($cateInfo);
        foreach ($cateInfo['article'] as $k => $v) {
            $v->together('comments')->delete();
        }
        $result = $cateInfo->together('article')->delete();
        if ($result) {
            $this->success('删除成功', 'admin/cate/lister');
        } else {
            $this->error('删除失败');
        }
        return view();
    }


}