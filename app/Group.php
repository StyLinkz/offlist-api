<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Group
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Offer whereUpdatedAt($value)
 */
class Group extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    public function contacts() {
        return $this->belongsToMany('App\Contact')->withTimestamps();
    }

    public function offers() {
        return $this->belongsToMany('App\Offer')->withTimestamps();
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
