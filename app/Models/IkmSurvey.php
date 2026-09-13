<?php

namespace App\Models;

class IkmSurvey extends BaseModel
{
    protected $fillable = [
        'respondent_type',
        'rating_service_ease',
        'rating_speed',
        'rating_transparency',
        'rating_satisfaction',
        'feedback',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'rating_service_ease' => 'integer',
            'rating_speed' => 'integer',
            'rating_transparency' => 'integer',
            'rating_satisfaction' => 'integer',
        ];
    }
}
