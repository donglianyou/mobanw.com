<?php

namespace App\Admin\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CategoryController extends Controller
{
    public $states = [
        'on'  => ['value' => 1, 'text' => '开启', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
    ];
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
            ->header('栏目分类')
            ->description('文章分类列表')
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
            ->header('文章分类详情')
            ->description('文章分类详情')
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
            ->header('修改分类')
            ->description('修改文章分类')
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
            ->header('创建分类')
            ->description('创建文章分类')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);
        $grid->id(trans('admin.id'));
        $grid->name(trans('admin.name'));
        $grid->sort(trans('admin.sort'));
        $grid->statu(trans('admin.statu'))->switch($this->states);
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
        $show = new Show(Category::findOrFail($id));
        $show->id(trans('admin.id'));
        $show->name(trans('admin.name'));
        $show->sort(trans('admin.sort'));
        $show->statu(trans('admin.statu'))->as(function($statu){
            if($statu){
                return "开启";
            }else{
                return "关闭";
            }
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);
        $form->display('id',trans('admin.id'));
        $form->text('name', trans('admin.classname'))->rules('required|min:2|max:10');
        $form->number('sort', trans('admin.sort'))->default('0')->min(0)->max(1000000);
        $states = [
            'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
        ];
        $form->switch('statu', trans('admin.statu'))->states($this->states)->default('1');


        return $form;
    }
}
