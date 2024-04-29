<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $name
 * @property string $definition
 * @property string $fk_dictionary_id
 */
class Concept extends Model
{
    use HasFactory, HasUuids;

    public function dictionary() : BelongsTo
    {
        return $this->belongsTo(Dictionary::class, 'fk_dictionary_id');
    }

    public function attachements() : HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function attributes() : BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'concept_attributes', 'fk_concept_id', 'fk_attribute_id');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Concept::class, 'fk_parent_concept_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Concept::class, 'fk_parent_concept_id');
    }

    protected $fillable = [
        'name',
        'definition',
        'fk_dictionary_id',
        'fk_parent_concept_id',
    ];

    protected $casts = [

    ];
}
