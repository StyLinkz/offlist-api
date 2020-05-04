<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Wishlist
 *
 * @property int $id
 * @property int $user_id
 * @property int $offer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 */
class Wishlist extends Pivot
{
    protected $fillable = [
        'user_id',
        'offer_id',
    ];

    public function scopeIsOwner($query, $user)
    {
        $user_id = $user;
        if ($user instanceof User) {
            $user_id = $user->id;
        }
        $query->where('user_id', $user_id);
    }

}
