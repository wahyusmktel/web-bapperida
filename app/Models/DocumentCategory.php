<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(PlanningDocument::class, 'category_id');
    }
}
