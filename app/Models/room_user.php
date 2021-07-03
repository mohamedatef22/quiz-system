<?php

namespace App\Models;

use Database\Factories\RoomUserFactory;
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

    protected static function newFactory()
    {
        return RoomUserFactory::new ();
    }
}
