<?php

namespace App\Models;

use App\Enums\Visibility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property Visibility $visibility
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $fk_user_id
 */
class Dictionary extends Model
{
    use HasFactory, HasUuids;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'fk_user_id');
    }

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'dictionary_tags', 'fk_dictionary_id', 'fk_tag_id');
    }

    public function concepts() : HasMany
    {
        return $this->hasMany(Concept::class, 'fk_dictionary_id');
    }

    public function rootConcept() : Concept
    {
        // TODO: check if dict is empty
        return $this->concepts()->oldest('created_at')->first();
    }

    protected $fillable = [
        'name',
        'description',
        'visibility',
        'fk_user_id',
    ];

    /**
     * Столбцы из базы данных, которые должны быть замаплены на заданные модели.
     */
    protected $casts = [
        'visibility' => Visibility::class,
    ];
}
