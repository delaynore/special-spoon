<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property string $id
 * @property string $name
 * @property string $definition
 * @property Dictionary $dictionary
 * @property string $fk_dictionary_id
 * @property string $fk_parent_concept_id
 */
class Concept extends Model
{
    use HasFactory, HasUuids;

    public function dictionary(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'fk_dictionary_id');
    }

    public function attachements(): HasMany
    {
        return $this->hasMany(Attachment::class, 'fk_concept_id');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'concept_attributes', 'fk_concept_id', 'fk_attribute_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Concept::class, 'fk_parent_concept_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Concept::class, 'fk_parent_concept_id');
    }

    public function allChildren()
    {
        return DB::select("
        WITH RECURSIVE concept_tree AS (
          SELECT id, name, fk_parent_concept_id
          FROM concepts
          WHERE id = '{$this->id}'
          UNION ALL
          SELECT c.id, c.name, c.fk_parent_concept_id
          FROM concepts c
          JOIN concept_tree ct ON c.fk_parent_concept_id = ct.id
        )
        SELECT * FROM concept_tree
        WHERE id != '{$this->id}';
    ");
    }

    public function conceptAttributes(): HasMany
    {
        return $this->hasMany(ConceptAttribute::class, 'fk_concept_id');
    }

    public function relatedConcepts1(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class, 'concept_relations', 'fk_concept_1_id', 'fk_concept_2_id');
    }

    public function relatedConcepts2(): BelongsToMany
    {
        return $this->belongsToMany(Concept::class, 'concept_relations', 'fk_concept_2_id', 'fk_concept_1_id');
    }

    protected $fillable = [
        'name',
        'definition',
        'fk_dictionary_id',
        'fk_parent_concept_id',
    ];

    protected $casts = [];
}
