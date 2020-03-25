<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Offer
 *
 * @property int $id
 * @property int $offer_type_id
 * @property int $offer_category_id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property string $commission
 * @property string $tax
 * @property string $images
 * @property string $location
 * @property string $documents
 * @property string $seller
 * @property string $data
 * @property string $publish_type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereOfferTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereOfferCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePublishType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
    protected $fillable = [
        'title',
        'description',
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
        'publish_type',
        'status',
    ];

    public function type() {
        return $this->hasOne('App\OfferType',  'id', 'offer_type_id');
    }

    public function category() {
        return $this->hasOne('App\OfferCategory', 'id', 'offer_category_id');
    }

    public function tags() {
        return $this->hasMany('App\OfferTag');
    }
}
