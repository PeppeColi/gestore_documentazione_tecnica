<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $path
 * @property boolean $approved
 * @property int $project_id
 */
class Document extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'path',
        'project_id',
        'approved',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'approved' => 'boolean',
    ];

    ///////////////
    // Relations //
    ///////////////

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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
