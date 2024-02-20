<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class Project extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
    ];

    ///////////////
    // Relations //
    ///////////////

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
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
