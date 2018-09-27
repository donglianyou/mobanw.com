<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use App\Models\Plugin;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PluginController extends Controller
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
            ->header('插件模块')
            ->description('插件模块列表')
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
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('修改插件模块')
            ->description('修改插件模块')
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
            ->header('添加插件模块')
            ->description('添加插件模块')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Plugin);

        $grid->id(trans('admin.id'))->sortable();
        $grid->title(trans('admin.title'));
        $grid->tags(trans('admin.tags'))->pluck('name')->label();
        $grid->demo_url(trans('admin.demo_url'))->display(function($demo_url) {
            if($demo_url){
                return "<a href='{$demo_url}' target='_blank'>{$demo_url}</a>";
            }
        });
        $grid->size(trans('admin.size'))->sortable();
        $grid->score(trans('admin.score'))->sortable();
        $grid->click(trans('admin.download'))->sortable();
        $grid->updated_at(trans('admin.updated_at'));
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
        $show = new Show(Plugin::findOrFail($id));

        $show->id(trans('admin.id'));
        $show->title(trans('admin.title'));
        $show->keywords(trans('admin.keywords'));
        $show->description(trans('admin.description'));
        $show->picture(trans('admin.picture'))->image();
        $show->source(trans('admin.source'));
        $show->demo_url(trans('admin.demo_url'));
        $show->tags(trans('admin.tags'));
        $show->size(trans('admin.size'));
        $show->score(trans('admin.score'));
        $show->click(trans('admin.download'));
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
        $form = new Form(new Plugin);
        $form->display('id', trans('admin.id'));
        $form->text('title', Config('admin.must').trans('admin.title'));
        $form->text('keywords', trans('admin.keywords'));
        $form->text('description', trans('admin.description'));
        $form->image('picture', Config('admin.must').trans('admin.picture'))->removable();
        $form->file('source', Config('admin.must').trans('admin.source'));
        $form->url('demo_url', trans('admin.demo_url'));
        $form->multipleSelect('tags', Config('admin.must').trans('admin.tags'))->options(Tag::all()->pluck('name', 'id'));
        $form->text('size', trans('admin.size'));
        $form->number('score', trans('admin.score'));
        $form->number('click', trans('admin.download'));
        /* $form->saving(function (Form $form) {
            if($form->source->size()){
                $form->size = $form->source->size();
            }
        }); */
        return $form;
    }
}
