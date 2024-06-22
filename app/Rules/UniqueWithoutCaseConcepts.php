<?php

namespace App\Rules;

use App\Models\Concept;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueWithoutCaseConcepts implements ValidationRule
{
    protected string $column;
    protected array $where;

    public function __construct(array $where = [])
    {
        $this->where = $where;
    }

    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $query = Concept::where('name', 'ilike', $value);
        foreach ($this->where as $column => $value) {
            $query->where($column, $value);
        }
        if ($query->exists()) {
            $fail('The :attribute has already been 1.');
        }
    }
}
