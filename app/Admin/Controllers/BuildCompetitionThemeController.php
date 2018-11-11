<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\BuildCompetitionThemeDivision;
use Illuminate\Support\Facades\Validator;

class BuildCompetitionThemeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('建築コンペ：テーマ管理');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $theme_division_id
     * @return Content
     */
    public function edit($theme_division_id)
    {
        return Admin::content(function (Content $content) use ($theme_division_id) {

            $content->header('建築コンペ：テーマ編集');
//            $content->description('description');

            $content->body($this->form()->edit($theme_division_id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('建築コンペ：テーマ一覧');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(BuildCompetitionThemeDivision::class, function (Grid $grid) {

            $grid->id('テーマID')->sortable();
            $grid->build_competition_manage_id('開催回')->sortable();
            $grid->theme_division_name('テーマ種別')->sortable();
            $grid->glyphicon('グラフアイコン')->sortable();
            $grid->created_at('作成日')->sortable();
            $grid->updated_at('更新日')->sortable();

            $grid->filter(function($filter){

                // Remove the default id filter
                $filter->disableIdFilter();

                // Add a column filter
                $filter->like('id', 'テーマID');
                $filter->like('build_competition_manage_id', '開催回');
                $filter->like('theme_division_name', 'テーマ種別');
                $filter->like('glyphicon', 'グラフアイコン');
                $filter->like('created_at', '作成日');
                $filter->like('updated_at', '更新日');
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(BuildCompetitionThemeDivision::class, function (Form $form) {
            $form->text('build_competition_manage_id', '建築コンペ開催回');
            $form->text('theme_division_name', 'テーマ種別');
            $form->text('glyphicon', 'グラフアイコン');
        });
    }

}
