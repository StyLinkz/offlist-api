<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));

        $grid->column('fullname', __('Full name'))
          ->display(function () {
            return $this->prename . ' ' . $this->name;
          });

        $grid->column('avatar', __('Avatar'))->image();

        $grid->column('email', __('Email'))->display(function ($email) {
          return '<a href="mailTo:' . $email. '">' . $email . '</a>';
        });

        $grid->column('phone', __('Phone'))->display(function ($phone) {
          return '<a href="tel:' . $phone . '">' . $phone . '</a>';
        });

        $grid->column('company', __('Company'));

        $grid->column('invitation_limit', __('Invitation limit'));

        $grid->column('created_at', __('Created at'))
          ->display(function ($created_at) {
            return date('Y-m-d', strtotime($created_at));
          });

        // $grid->column('address', __('Address'));
        // $grid->column('city', __('City'));
        // $grid->column('zip_code', __('Zip code'));
        // $grid->column('website', __('Website'));
        // $grid->column('offer_types', __('Offer types'));
        // $grid->column('role', __('Role'));
        // $grid->column('email_verifed_at', __('Email verified at'));
        // $grid->column('password', __('Password'));
        // $grid->column('invitation_limit', __('Invitation limit'));
        // $grid->column('remember_token', __('Remember token'));
        // $grid->column('api_token', __('Api token'));
        // $grid->column('reset_password_token', __('Reset password token'));
        // $grid->column('reset_password_token_expired_at', __('Reset password token expired at'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('prename', __('Prename'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('avatar', __('Avatar'));
        $show->field('company', __('Company'));
        $show->field('address', __('Address'));
        $show->field('city', __('City'));
        $show->field('zip_code', __('Zip code'));
        $show->field('website', __('Website'));
        $show->field('offer_types', __('Offer types'));
        $show->field('role', __('Role'));
        $show->field('invitation_limit', __('Invitation limit'));
        // $show->field('password', __('Password'));
        // $show->field('email_verified_at', __('Email verified at'));
        // $show->field('remember_token', __('Remember token'));
        // $show->field('api_token', __('Api token'));
        // $show->field('reset_password_token', __('Reset password token'));
        // $show->field('reset_password_token_expired_at', __('Reset password token expired at'));
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
        $form = new Form(new User());

        $form->text('prename', __('Prename'));
        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->mobile('phone', __('Phone'));
        $form->image('avatar', __('Avatar'));
        $form->text('company', __('Company'));
        $form->text('address', __('Address'));
        $form->text('city', __('City'));
        $form->text('zip_code', __('Zip code'));
        $form->text('website', __('Website'));
        $form->text('offer_types', __('Offer types'));
        $form->text('role', __('Role'))->default('user');
        // $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        // $form->password('password', __('Password'));
        // $form->number('invitation_limit', __('Invitation limit'))->default(5);
        // $form->text('remember_token', __('Remember token'));
        // $form->text('api_token', __('Api token'));
        // $form->text('reset_password_token', __('Reset password token'));
        // $form->datetime('reset_password_token_expired_at', __('Reset password token expired at'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
