<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Show;

class TagController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('标签管理')
            ->description('所有标签')
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
            ->header('插件模块详情')
            ->description('插件模块详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('修改标签')
            ->description('修改标签')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('添加标签')
            ->description('添加标签')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tag());

        $grid->id(trans('admin.id'))->sortable();

        $grid->name(trans('admin.name'))->editable();
        $states = [
            'on' => ['text' => 'YES'],
            'off' => ['text' => 'NO'],
        ];

        $grid->column('switch_group')->switchGroup([
            'recommend' => '推荐', 'hot' => '热门', 'new' => '最新'
        ], $states);

        $grid->updated_at(trans('admin.updated_at'));

        $grid->filter(function ($filter) {
            $filter->between('updated_at')->datetime();
        });

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
        $show = new Show(Tag::findOrFail($id));

        $show->id(trans('admin.id'));
        $show->name(trans('admin.name'));
        $show->recommend(trans('admin.recommend'));
        $show->hot(trans('admin.hot'));
        $show->new(trans('admin.new'));
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
        $form = new Form(new Tag());

        $form->display('id', trans('admin.id'));
        $form->text('name', trans('admin.name'))->rules('required');
        $form->switch('recommend', trans('admin.recommend'));
        $form->switch('hot', trans('admin.hot'));
        $form->switch('new', trans('admin.new'));

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }
}
