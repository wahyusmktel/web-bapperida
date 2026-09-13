<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'code',
        'slug',
        'description',
        'color',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(NewsArticle::class, 'category_id');
    }
}
