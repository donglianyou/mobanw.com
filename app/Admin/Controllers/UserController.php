<?php

namespace App\Admin\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('查看详情')
            ->description('查看会员详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->id('编号');
        $grid->name('用户名');
        $grid->avatar('头像')->display(function ($avatar) {
            return "<img src='/uploads/$avatar' width='100px'>";
        });
        $grid->phone('手机号');
        $grid->email('邮箱');
        $grid->created_at('注册时间');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->id('编号');
        $show->name('用户名');
        $show->email('邮箱');
        $show->password('密码');
        $show->phone('手机号');
        $show->avatar('头像')->image();
        $show->sex('性别')->using(['f' => '女', 'm' => '男']);
        $show->scores('积分');
        $show->city('所在城市');
        $show->remember_token('记住令牌');
        $show->created_at('创建时间');
        $show->updated_at('修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', '用户名')->rules('required|min:2');
        $form->email('email', '邮箱');
        $form->password('password', '密码');
        $form->image('avatar', '头像')->removable();
        $form->text('remember_token', '记住令牌');
        $form->radio('sex', '性别')->options(['m'=> '男', 'f' => '女'])->default('男');
        $form->mobile('phone','手机号');
        $form->text('city', '所在城市');
        $form->number('scores','积分')->default('0')->min(0)->max(1000000);
        
        return $form;
    }
}
