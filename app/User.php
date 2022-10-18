<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyApiEmail;
use App\Notifications\PasswordResetNotification;
use Livijn\MultipleTokensAuth\Traits\HasApiTokens;

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
 * @property string $offer_types
 * @property string $role
 * @property string $password
 * @property string $raw_password
 * @property int $invitation_limit
 * @property string|null $remember_token
 * @property string|null $api_token
 * @property string|null $reset_password_token
 * @property datetime|null $reset_password_token_expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRawPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        'offer_types',
        'password',
        'raw_password',
        'role',
//        'api_token',
        'invitation_limit',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'reset_password_token',
        'reset_password_token_expired_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Wishlist offers
     *
     * @return mixed
     */
    public function wishlistOffers() {
        return $this->belongsToMany('App\Offer', 'wishlists', 'user_id', 'offer_id')
                    ->withTimestamps();
    }

    /**
     * applications
     *
     * @return mixed
     */
    public function applications() {
        return $this->belongsToMany('App\Application')
                    ->withTimestamps();
    }

    /**
     * invitations
     *
     * @return mixed
     */
    public function invitations() {
        return $this->hasMany('App\Invitation')
                    ->withTimestamps();
    }

    /**
     * Send API email verification notification
     */
    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail);
    }

    /**
     * Generate token
     *
     * @return string $apiToken
     */
    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->save();
        return $this->api_token;
    }

    /**
     * Generate reset-password token
     *
     * @return string $resetPasswordToken
     */
    public function generateResetPasswordToken()
    {
        $this->reset_password_token = Str::random(6);
        $this->reset_password_token_expired_at = Carbon::now()->addHour();
        $this->save();
        return $this->reset_password_token;
    }

    /**
     * Reset password
     *
     * @param string $password
     * @return void
     */
    public function resetPassword($password) {
        $this->password = Hash::make($password);
        $this->reset_password_token = null;
        $this->reset_password_token_expired_at = null;
        $this->save();
    }
}
