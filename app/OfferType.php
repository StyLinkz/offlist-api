<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OfferType
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OfferType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfferType extends Model
{
    protected $fillable = ['name', 'display_name'];
}
