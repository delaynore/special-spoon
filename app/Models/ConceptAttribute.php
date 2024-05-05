<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class ConceptAttribute extends Model
{
    use HasFactory, HasUuids;

    public function concept() : BelongsTo
    {
        return $this->belongsTo(Concept::class, 'fk_concept_id');
    }

    public function attribute() : BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'fk_attribute_id');
    }

    public function values() : HasMany
    {
        return $this->hasMany(ConceptAttributeValue::class, 'fk_concept_attribute_id');
    }

    protected $fillable = [
        'fk_concept_id',
        'fk_attribute_id',
    ];
}
