<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory, HasUuids;

    public function dictionaries(): BelongsToMany
    {
        return $this->belongsToMany(Dictionary::class, 'dictionary_tags', 'fk_tag_id', 'fk_dictionary_id');
    }

    protected $fillable = [
        'name'
    ];
}
