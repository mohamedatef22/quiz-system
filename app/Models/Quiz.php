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

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_quiz')
            ->as('quiz')
            ->withPivot([
                'grade',
                'started_at',
                'ended_at',
            ]);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
