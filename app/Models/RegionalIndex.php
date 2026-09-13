<?php

namespace App\Models;

class RegionalIndex extends BaseModel
{
    protected $table = 'regional_indexes';

    protected $fillable = [
        'name',
        'code',
        'year',
        'score',
        'predicate',
        'evaluator',
        'description',
        'file_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'score' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
