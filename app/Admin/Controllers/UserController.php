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

        $grid->id(trans('admin.id'));
        $grid->name(trans('admin.username'));
        $grid->avatar(trans('admin.avatar'))->display(function ($avatar) {
            if($avatar){
                return "<img src='/uploads/$avatar' width='100px'>";
            }
        });
        $grid->phone(trans('admin.phone'));
        $grid->email(trans('admin.email'));
        $grid->created_at(trans('admin.created_at'));
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

        $show->id(trans('admin.id'));
        $show->name(trans('admin.username'));
        $show->email(trans('admin.email'));
        $show->phone(trans('admin.phone'));
        $show->avatar(trans('admin.avatar'))->image();
        $show->sex(trans('admin.sex'))->using(['男' => '男', '女' => '女', '保密' => '保密']);
        $show->scores(trans('admin.scores'));
        $show->city(trans('admin.city'));
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

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
        $form->display('id',trans('admin.id'));
        $form->text('name', trans('admin.username'))->rules('required|min:2');
        $form->email('email', trans('admin.email'));
        $form->password('password', trans('admin.password'))->default(function($form) {
            return $form->model()->password;
        });
        $form->image('avatar', trans('admin.avatar'))->removable();
        $form->radio('sex', trans('admin.sex'))->options(['男' => '男', '女' => '女', '保密' => '保密'])->default('保密');
        $form->mobile('phone',trans('admin.phone'));
        $form->text('city', trans('admin.city'));
        $form->number('scores', trans('admin.scores'))->default('0')->min(0)->max(1000000);
        $form->saving(function (Form $form) {
            if($form->password && $form->model()->password != $form->password){
                $form->password = bcrypt($form->password);
            }
        });
        return $form;
    }
}
