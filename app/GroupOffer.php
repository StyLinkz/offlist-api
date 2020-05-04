<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App|GroupOffer
 *
 * @property int $id
 * @property int $offer_id
 * @property int $group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupOffer extends Model
{
    protected $fillable = ['offer_id', 'group_id'];
}
