<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Offer
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
    protected $fillable = ['title', 'body'];
}
