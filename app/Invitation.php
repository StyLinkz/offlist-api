<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Invitation
 *
 * @property int $id
 * @property int $user_id
 * @property int $receiver_id
 * @property string $receiver_email
 * @property string $receiver_prename
 * @property string $receiver_name
 * @property string $code
 * @property datetime $expired_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereReceiverEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereReceiverName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereReceiverPrename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'receiver_id',
        'receiver_email',
        'receiver_prename',
        'receiver_name',
        'code',
        'expired_at',
        'status',
    ];

    /**
     * Get the user that owns the invitation.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
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
        });
    }

}
