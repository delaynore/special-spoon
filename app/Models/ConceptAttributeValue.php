<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $value
 * @property int $example_number
 * @property string $fk_concept_attribute_id
 */
class ConceptAttributeValue extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'fk_concept_attribute_id',
        'value',
        'example_number',
    ];
}
