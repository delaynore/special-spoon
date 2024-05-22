<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $description
 * @property mixed $name_plural
 */
class RelationType extends Model
{
    use HasFactory, HasUuids;

    public function relatedConcepts(): HasMany
    {
        return $this->hasMany(ConceptRelation::class, 'fk_relation_type_id');
    }

    protected $fillable = [
        'name',
        'description',
        'name_plural',
    ];
}
