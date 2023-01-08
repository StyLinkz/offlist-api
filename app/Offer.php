<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Offer
 *
 * @property int $id
 * @property int $offer_type_id
 * @property int $offer_category_id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property int $price
 * @property string $commission
 * @property string $images
 * @property string $location
 * @property string $documents
 * @property string $seller
 * @property string $data
 * @property string $status
 * @property string $market_type
 * @property string $available_type
 * @property string $publish_type
 * @property string $privacy
 * @property string $deleted_reason
 * @property int $is_free
 * @property int $is_verified
 * @property string $verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereOfferTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereOfferCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereMarketType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereAvailableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePublishType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereDeletedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
  protected $casts = [
    'images' => 'array',
    'location' => 'array',
    'data' => 'array',
    'seller' => 'array',
    'documents' => 'array',
  ];

  protected $fillable = [
    'code',
    'title',
    'description',
    'user_id',
    'offer_type_id',
    'offer_category_id',
    'price',
    'commission',
    'tax',
    'images',
    'location',
    'documents',
    'seller',
    'data',
    'status',
    'market_type',
    'available_type',
    'publish_type',
    'privacy',
    'deleted_reason',
    'is_free',
    'is_verified',
    'verified_at',
  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id', 'id');
  }

  public function type()
  {
    return $this->hasOne('App\OfferType', 'id', 'offer_type_id');
  }

  public function category()
  {
    return $this->hasOne('App\OfferCategory', 'id', 'offer_category_id');
  }

  public function tags()
  {
    return $this->belongsToMany('App\Tag', 'offer_tags', 'offer_id', 'tag_id')
      ->withTimestamps();
  }

  public function groups()
  {
    return $this->belongsToMany('App\Group', 'offer_groups', 'offer_id', 'group_id')
      ->withTimestamps();
  }

  /**
   * Wishlist users
   *
   * @return mixed
   */
  public function wishlistUsers()
  {
    return $this->belongsToMany('App\User', 'wishlists', 'offer_id', 'user_id')
      ->withTimestamps();
  }

  /**
   * applications
   *
   * @return mixed
   */
  public function applications()
  {
    return $this->belongsToMany('App\Application')
      ->withTimestamps();
  }

  /**
   * Scope for feed
   *
   * @param $query
   * @param User $user
   */
  public function scopeFeed($query, User $user)
  {
    $user_id = $user->id;
    $query->where(function ($query) use ($user_id) {
      // $query->where('user_id', '!=', $user_id);
      $query->where('privacy', '=', 'public');
      $query->where('status', '=', 'activated');
    });
  }

  /**
   * Scope Filter
   *
   * @param $query
   * @param Request $request
   */
  public function scopeFilter($query, Request $request)
  {
    if ($types = $request->input('types')) {
      $query->where(function ($query) use ($types) {
        $query->whereIn('offer_type_id', explode(',', $types));
        $query->where('status', '=', 'activated');
      });
    }

    if ($market_types = $request->input('market_types')) {
      $query->where(function ($query) use ($market_types) {
        $query->whereIn('market_type', explode(',', $market_types));
        $query->where('status', '=', 'activated');
      });
    }
  }

  /**
   * Scope for the authed user
   *
   * @param $query
   * @param User $user
   */
  public function scopeAuth($query, User $user)
  {
    $user_id = $user->id;
    $query->where(function ($query) use ($user_id) {
      $query->where('user_id', '=', $user_id);
      $query->where('status', '!=', 'deleted');
    });
  }

  /**
   * Scope for free offers
   *
   * @param $query
   */
  public function scopeFree($query)
  {
    $query->where(function ($query) {
      $query->where('is_free', '=', '1');
      $query->where('status', '=', 'activated');
    });
  }
}
