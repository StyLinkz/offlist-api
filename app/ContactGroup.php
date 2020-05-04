<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App|GroupContact
 *
 * @property int $id
 * @property int $group_id
 * @property int $contact_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactGroup extends Model
{
    protected $fillable = ['group_id', 'contact_id'];
}
