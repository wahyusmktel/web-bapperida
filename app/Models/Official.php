<?php

namespace App\Models;

class Official extends BaseModel
{
    protected $fillable = [
        'name',
        'nip',
        'position',
        'category_code',
        'photo_path',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
