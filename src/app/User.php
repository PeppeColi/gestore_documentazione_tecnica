<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $api_token
 * @property boolean $is_admin
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    ///////////////
    // Relations //
    ///////////////

    /**
     * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    ////////////////////////////
    // Accessors and mutators //
    ////////////////////////////

    //////////////////
    // Query scopes //
    //////////////////

    /////////////
    // Helpers //
    /////////////
}
