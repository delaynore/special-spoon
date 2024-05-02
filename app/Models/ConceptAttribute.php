<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class ConceptAttribute extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'fk_concept_id',
        'fk_attribute_id',
    ];
}
