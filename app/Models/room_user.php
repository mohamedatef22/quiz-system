<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_user extends Model
{
    use HasFactory;

    protected $table = 'room_user';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'room_id',
    ];
}
