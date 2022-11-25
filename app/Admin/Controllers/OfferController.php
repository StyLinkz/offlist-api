<?php

namespace App\Admin\Controllers;

use App\Offer;
use App\OfferCategory;
use App\OfferType;
use App\User;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Mail;

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
        $grid->column('title', __('Title'))->display(function ($title) {
          return '<a href="/admin/offers/' . $this->id . '/edit">' . $title . '</a>';
        });

        $grid->column('images')->display(function ($images) {
          $display_images = array();
          if (is_array($images) && !empty($images)) {
            foreach ($images as $image_item) {
              $display_images[] = $image_item['url'];
            }
          }
          return !empty($display_images) ? $display_images[0] : array();
        })->image();

        $grid->column('price', __('Price'))->display(function ($price) {
          $currency = $this->data && isset($this->data['primary'])
            ? $this->data['primary']['data']['currency']['value']
            : 'USD';
          switch ($currency) {
            case 'EUR':
              $symbol = '€';
              break;
            case 'GBP':
              $symbol = '£';
              break;
            case 'USD':
              $symbol = '$';
              break;
            case 'RMB':
              $symbol = '¥';
              break;
            case 'JPY':
              $symbol = '¥';
              break;
            default:
              $symbol = '$';
              break;
          }
          return $symbol . number_format($price);
        });

        $grid->column('is_free', __('Type'))
          ->display(function ($is_free) {
            return $is_free ? 'FREE' : 'LIMITED';
          })
          ->label(array(
            '1' => 'success',
            '0' => 'warning',
          ));

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
        $offer_types = OfferType::all();
        $offer_categories = OfferCategory::all();

        $offer_type_options = array();
        foreach ($offer_types as $offer_type) {
          $offer_type_options[$offer_type->id] = $offer_type->display_name;
        }

        $offer_category_options = array();
        foreach ($offer_categories as $offer_category) {
          $offer_category_options[$offer_category->id] = $offer_category->display_name;
        }

        $form->text('title', __('Title'));
        $form->text('user_id', __('User id'))->readonly();

        $form->select('offer_type_id', __('Offer type'))->options($offer_type_options);
        $form->select('offer_category_id', __('Offer category'))->options($offer_category_options);
        $form->text('price', __('Price'));
        $form->text('price_tax', __('Price tax'));
        $form->text('commission', __('Commission'));
        $form->textarea('images', __('Images'))->readonly();
        $form->textarea('location', __('Location'))->readonly();
        $form->textarea('documents', __('Documents'))->readonly();
        $form->textarea('seller', __('Seller'))->readonly();
        $form->textarea('data', __('Data'))->readonly();

        $form->select('privacy')->options(array(
          'public' => __('Public'),
          'private' => __('Private'),
        ));

        $form->select('status')->options(array(
          'activated' => __('Activated'),
          'deactivated' => __('Deactivated'),
        ));

        $form->select('market_type')->options(array(
          'onmarket' => __('Onmarket'),
          'offmarket' => __('Offmarket'),
        ));

        $form->select('available_type', __('Available type'))->options(array(
          'private' => __('Private'),
          'nonpublic' => __('Non-public'),
          'public' => __('Public'),
        ));

        $form->select('publish_type', __('Publish type'))->options(array(
          'auto' => __('Auto'),
          'manual' => __('Manual'),
        ));

        $form->select('is_free')->options(array(
          1 => __('Yes'),
          0 => __('No'),
        ));

        $form->select('is_verified')->options(array(
          1 => __('Yes'),
          0 => __('No'),
        ));

        $form->hidden('verified_at', __('Verified at'));

        $form->textarea('description', __('Description'));

        $form->submitted(function (Form $form) {
          // TODO: Ignore all JSON fields before saving onto the database for now
          $form->ignore('images');
          $form->ignore('location');
          $form->ignore('documents');
          $form->ignore('seller');
          $form->ignore('data');
        });

        $form->saving(function (Form $form) {
          /**
           * Check if the current offer is free or not
           * If it's a free offer, continue checking if it's verified by the admin or not
           * And if it does, just send a welcome message to the free user who created this offer along with his login credentials
           */
          // dump($form->is_free);
          // dump($form->is_verified);
          // dump($form->verified_at);
          // dump($form->user_id);
          // dump($form->is_free && $form->is_verified && !$form->verified_at);
          // die;
          if ($form->is_free && $form->is_verified && !$form->verified_at) {
            $user = User::find($form->user_id);
            if ($user) {
              // Set verified_at property
              $form->verified_at = Carbon::now()->toDateTimeString();

              // Also verify user account
              $user->update([
                'email_verified_at' => Carbon::now()->toDateTimeString(),
              ]);

              // Send a welcome message to the free user
              $this->_sendFreeAccountWelcomeNotification($user);
            }
          }
        });

        return $form;
    }

    protected function _sendFreeAccountWelcomeNotification(User $user)
    {
        $to_name = $user->prename . ' ' . $user->name;
        $to_email = $user->email;
        $data = [
          'name' => $to_name,
          'email' => $to_email,
          'password' => $user->raw_password,
        ];
        Mail::send(
          'templates.mail.freeAccountWelcomeNotification',
          $data,
          function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
              ->subject('[Offlist] Register Account Success');
            $message->from('info@offlist.de', 'Offlist');
          }
        );
    }
}
