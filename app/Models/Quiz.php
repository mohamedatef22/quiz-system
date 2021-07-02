<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'instruction',
        'time',
        'start_at',
        'end_at',
    ];
}
