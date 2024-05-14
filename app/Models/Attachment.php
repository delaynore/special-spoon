<?php

namespace App\Models;

use App\Enums\AttachmentType;
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
 * @property string $fk_concept_id
 * @property string $fk_user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
        'fk_concept_id',
        'fk_user_id',
        'path',
    ];

    protected $casts = [
        'type' => AttachmentType::class,
    ];
}
