<?php

namespace App\Models;

use App\Enums\DataType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $name
 * @property DataType $type
 * @property string $fkConceptId
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Attribute extends Model
{
    use HasFactory, HasUuids;

    public function concepts() : BelongsToMany {
        return $this->belongsToMany(Concept::class, 'concept_attributes', 'fk_attribute_id', 'fk_concept_id');
    }

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = [
        'id' => 'uuid',
        'name' => 'string',
        'type' => DataType::class,
        'fk_concept_id' => 'uuid',
    ];
}
