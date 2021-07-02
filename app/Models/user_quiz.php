<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_quiz extends Model
{
    use HasFactory;

    protected $table = 'user_quiz';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'quiz_id',
    ];
}
