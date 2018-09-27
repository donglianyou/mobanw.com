<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use DB;

class ArticleController extends Controller
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
            ->header('所有文章')
            ->description('所有文章列表')
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
            ->header('文章详情')
            ->description('文章详情页')
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
            ->header('修改文章')
            ->description('修改文章页')
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
            ->header('添加文章')
            ->description('添加文章页')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);
        $grid->id(trans('admin.id'));
        $grid->title(trans('admin.title'));
        $grid->typeid(trans('admin.typeid'))->display(function ($typeid) {
            $typename = Category::find($typeid)->name;
            return $typename;
        });
        $grid->description(trans('admin.description'));
        $grid->picture(trans('admin.picture'))->display(function ($picture) {
            if($picture){
                return "<img src='/uploads/$picture' width='100px'>";
            }
        });
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
        $show = new Show(Article::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);
        $form->display('id', trans('admin.id'));
        $form->select('typeid', trans('admin.typeid'))->options(Category::selectOptions());
        $form->text('title', trans('admin.title'))->rules('required');
        $form->text('keywords', trans('admin.keywords'));
        $form->textarea('description', trans('admin.description'));
        $form->editor('content', trans('admin.content'))->rules('required');
        $form->image('picture', trans('admin.picture'));

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');
        return $form;
    }
}
