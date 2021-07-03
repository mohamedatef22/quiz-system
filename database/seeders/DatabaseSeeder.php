<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Room;
use App\Models\room_user;
use App\Models\User;
use App\Models\user_quiz;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Question::truncate();
        Answer::truncate();
        Quiz::truncate();
        Room::truncate();
        room_user::truncate();
        user_quiz::truncate();

        $user1 = User::factory()->create();
        $users = User::factory(5)->create();
        // $user3 = User::factory()->create();
        // $user4 = User::factory()->create();

        $rooms = Room::factory()->count(5)->create([
            'user_id' => $user1,
        ]);

        foreach ($rooms as $room) {
            $quizzes = Quiz::factory(2)->create([
                'room_id' => $room,
            ]);

            for ($i = 0; $i < 5; $i++) {
                room_user::factory()->create([
                    'user_id' => $users[$i],
                    'room_id' => $room,
                ]);
            }
            foreach ($quizzes as $quiz) {

                for ($i = 0; $i < 5; $i++) {
                    user_quiz::factory()->create([
                        'user_id' => $users[$i],
                        'quiz_id' => $quiz,
                    ]);
                }
                $questions = Question::factory(10)->create([
                    'quiz_id' => $quiz,
                ]);
            }

            foreach ($questions as $question) {
                Answer::factory(5)->create([
                    'question_id' => $question,
                ]);
            }
        }

    }
}
