<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * App\User
 *
 * @property int $id
 * @property string $prename
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $address
 * @property string $city
 * @property string $zip_code
 * @property string $website
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AccessRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccessRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'prename',
        'name',
        'email',
        'phone',
        'company',
        'address',
        'city',
        'zip_code',
        'website',
        'reason',
    ];
}
