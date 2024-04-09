<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $fkConcept1Id
 * @property string $fkConcept2Id
 * @property string $fkRelationTypeId
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class ConceptRelation extends Model
{
    use HasFactory, HasUuids;

    public function concept1() : BelongsTo
    {
        return $this->belongsTo(Concept::class, 'fk_concept_1_id');
    }

    public function concept2() : BelongsTo
    {
        return $this->belongsTo(Concept::class, 'fk_concept_2_id');
    }

    public function relationType() : BelongsTo
    {
        return $this->belongsTo(RelationType::class, 'fk_relation_type_id');
    }

    protected $fillable = [
        'fk_concept_1_id',
        'fk_concept_2_id',
        'fk_relation_type_id',
    ];

}
