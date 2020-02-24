<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Invitation
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $receiver_email
 * @property string $receiver_prename
 * @property string $receiver_name
 * @property string $code
 * @property timestamp $expired_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereTitle($value)
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
        'sender_id',
        'receiver_id',
        'receiver_email',
        'receiver_prename',
        'receiver_name',
        'code',
        'expired_at',
        'status',
    ];
}
