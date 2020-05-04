<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Application
 *
 * @property int $id
 * @property int $user_id
 * @property int $offer_id
 * @property int $sender_id
 * @property string $sender_name
 * @property string $sender_prename
 * @property string $sender_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereSenderPrename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereSenderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Application whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'offer_id',
        'sender_id',
        'sender_prename',
        'sender_name',
        'sender_email',
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function offer() {
        return $this->hasOne('App\Offer', 'id', 'offer_id');
    }

    public function sender() {
        return $this->hasOne('App\User', 'id', 'sender_id');
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
            $query->where('sender_id', '=', $user_id);
        });
    }

    /**
     * Scope for the sender user
     *
     * @param $query
     * @param $request
     */
    public function scopeReceive($query, User $user)
    {
        $user_id = $user->id;
        $query->where(function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        });
    }

}
