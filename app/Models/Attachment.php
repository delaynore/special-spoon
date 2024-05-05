<?php

namespace App\Models;

use App\Enums\DataType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $name
 * @property DataType $type
 * @property string $path
 * @property string $fkConceptId
 * @property string $fkUserId
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Attachment extends Model
{
    use HasFactory, HasUuids;

    public function concept(): BelongsTo
    {
        return $this->belongsTo(Concept::class, 'fk_concept_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fk_user_id');
    }


    protected $fillable = [
        'name',
        'type',
        'fk_concept_id'
    ];

    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'type' => DataType::class,
        'path' => 'string',
        'fk_concept_id' => 'uuid',
        'fk_user_id' => 'uuid',
    ];
}
