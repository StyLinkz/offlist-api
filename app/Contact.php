<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Contact
 *
 * @property int $id
 * @property int $user_id
 * @property int $contact_user_id
 * @property string $name
 * @property string $prename
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereContactUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePrename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 */
class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'contact_user_id',
        'avatar',
        'name',
        'prename',
        'email',
        'phone',
    ];

    public function groups() {
        return $this->belongsToMany('App\Group')->withTimestamps();
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
