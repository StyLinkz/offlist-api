<?php

namespace App\Admin\Controllers;

use App\Offer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OfferController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Offer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Offer());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));

        $grid->column('images')->display(function ($images) {
          $display_images = array();
          if (is_array($images) && !empty($images)) {
            foreach ($images as $image_item) {
              $display_images[] = $image_item['url'];
            }
          }
          return !empty($display_images) ? $display_images[0] : array();
        })->image();

        $grid->column('price', __('Price'));


        $grid->column('market_type', __('Market type'))
          ->display(function ($market_type) {
            return strtoupper($market_type);
          })
          ->label(array(
            'onmarket' => 'info',
            'offmarket' => 'warning',
          ));

        $grid->column('privacy', __('Privacy'))
          ->display(function ($privacy) {
            return strtoupper($privacy);
          })
          ->label(array(
            'public' => 'success',
            'private' => 'default',
          ));

        $grid->column('status', __('Status'))
          ->display(function ($status) {
            return strtoupper($status);
          })
          ->label(array(
            'activated' => 'success',
            'deactivated' => 'danger',
          ));

        $grid->column('created_at', __('Created at'))
          ->display(function ($created_at) {
            return date('Y-m-d', strtotime($created_at));
          });

        // $grid->column('description', __('Description'));
        // $grid->column('commission', __('Commission'));
        // $grid->column('available_type', __('Available type'));
        // $grid->column('publish_type', __('Publish type'));
        // $grid->column('is_free', __('Is free'));
        // $grid->column('is_verified', __('Is verified'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Offer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('offer_type_id', __('Offer type id'));
        $show->field('offer_category_id', __('Offer category id'));
        $show->field('price', __('Price'));
        $show->field('price_tax', __('Price tax'));
        $show->field('commission', __('Commission'));
        $show->field('images', __('Images'));
        $show->field('location', __('Location'));
        $show->field('documents', __('Documents'));
        $show->field('seller', __('Seller'));
        $show->field('data', __('Data'));
        $show->field('privacy', __('Privacy'));
        $show->field('status', __('Status'));
        $show->field('market_type', __('Market type'));
        $show->field('available_type', __('Available type'));
        $show->field('publish_type', __('Publish type'));
        $show->field('is_free', __('Is free'));
        $show->field('is_verified', __('Is verified'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
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
        $form = new Form(new Offer());

        $form->text('title', __('Title'));
        $form->text('user_id', __('User id'))->readonly();
        $form->text('offer_type_id', __('Offer type id'))->readonly();
        $form->text('offer_category_id', __('Offer category id'))->readonly();
        $form->text('price', __('Price'));
        $form->text('price_tax', __('Price tax'));
        $form->text('commission', __('Commission'));
        $form->textarea('images', __('Images'));
        $form->textarea('location', __('Location'));
        $form->textarea('documents', __('Documents'));
        $form->textarea('seller', __('Seller'));
        $form->textarea('data', __('Data'));

        $form->select('privacy')->options(array(
          'public' => __('Public'),
          'private' => __('Private'),
        ));

        $form->select('status')->options(array(
          'activated' => __('Activated'),
          'deactivated' => __('Deactivated'),
        ));

        $form->select('market_type')->options(array(
          'offmarket' => __('Onmarket'),
          'onmarket' => __('Offmarket'),
        ));

        $form->text('available_type', __('Available type'));
        $form->text('publish_type', __('Publish type'));
        $form->switch('is_free', __('Is free'));
        $form->switch('is_verified', __('Is verified'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
