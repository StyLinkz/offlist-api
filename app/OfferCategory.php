<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OfferCategory
 *
 * @property int $id
 * @property int $offer_type_id
 * @property string $name
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory whereOfferTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory whereDislayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfferCategory extends Model
{
    protected $fillable = ['offer_type_id', 'name', 'display_name'];
}
