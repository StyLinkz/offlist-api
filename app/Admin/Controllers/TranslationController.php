<?php

namespace App\Admin\Controllers;

use App\Language;
use App\Translation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TranslationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Translation';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Translation());

        $grid->column('id', __('Id'));
        $grid->column('text', __('Text'));

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
        $show = new Show(Translation::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('text', __('Text'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $languages = Language::all();
        $form = new Form(new Translation());

        /* Build form */
        $form->text('text', __('Text'));
        foreach ($languages as $language) {
          $field_name = 'text_' . $language->id;
          $form->text($field_name, __('Translation in ' . $language->name))
            ->default(function (Form $form) use ($language) {
              $translation = $form->model()
                ->languages
                ->find($language->id);
              return $translation->pivot->translation_text;
            });
        }

        /* Ignore translation texts while saving the original text */
        $form->submitted(function (Form $form) use ($languages) {
          foreach ($languages as $language) {
            $language_translation_text = 'text_' . $language->id;
            $form->ignore($language_translation_text);
          }
        });

        /* Handle save original text */
        $form->saved(function (Form $form) use ($languages) {
          $post_data = $_POST;
          foreach ($languages as $language) {
            $translation_id = $form->model()->id;
            $language_translation_text = 'text_' . $language->id;
            $language->translations()->detach([$translation_id]);
            $language->translations()->attach(
              $translation_id,
              array('translation_text' => $post_data[$language_translation_text])
            );
          }
        });

        return $form;
    }
}
