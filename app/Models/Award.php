<?php

namespace App\Models;

class Award extends BaseModel
{
    protected $table = 'awards';

    protected $fillable = [
        'name',
        'slug',
        'year',
        'award_date',
        'category',
        'organizer',
        'description',
        'image_path',
        'order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'award_date' => 'date',
            'order' => 'integer',
            'is_published' => 'boolean',
        ];
    }
}
