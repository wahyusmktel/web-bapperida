<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanningDocument extends BaseModel
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'year',
        'document_number',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'file_mime',
        'downloads_count',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'file_size' => 'integer',
            'downloads_count' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Human-readable file size.
     */
    public function formattedFileSize(): string
    {
        if (! $this->file_size) {
            return '-';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $this->file_size > 0 ? floor(log($this->file_size, 1024)) : 0;

        return number_format($this->file_size / (1024 ** $power), 2, ',', '.').' '.$units[$power];
    }
}
