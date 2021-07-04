<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'password',
    ];
    // hide password
    protected $hidden = [
        'password',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'room_user')
            ->as('user')
            ->withPivot(['enrolled_at']);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
