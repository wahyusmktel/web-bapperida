<?php

namespace App\Models;

class DataRequest extends BaseModel
{
    protected $fillable = [
        'ticket_number',
        'name',
        'email',
        'phone',
        'institution',
        'purpose',
        'data_description',
        'status',
        'notes',
    ];
}
