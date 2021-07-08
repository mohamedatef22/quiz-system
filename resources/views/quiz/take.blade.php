@extends('shared.main')
@php
App\Models\user_quiz::create([
    'user_id' => Auth::user()->id,
    'quiz_id' => $quiz->id,
]);
@endphp
@section('main')
    <div id="clockdiv" class="flex space-x-2 mx-auto items-center mt-5">
        <div class="text-xs sm:text-lg text-red-600">
            Starts in
        </div>
        <div class="bg-indigo-400 py-2 flex flex-col items-center justify-center w-14 sm:w-20">
            <span class="days p-2 sm:w-10 text-center bg-indigo-300 text-sm sm:text-lg text-white"></span>
            <div class="sm:text-sm text-xs text-white">Days</div>
        </div>
        <div class="bg-indigo-400 py-2 flex flex-col items-center justify-center w-14 sm:w-20">
            <span class="hours p-2 sm:w-10 text-center bg-indigo-300 text-sm sm:text-lg text-white"></span>
            <div class="sm:text-sm text-xs text-white">Hours</div>
        </div>
        <div class="bg-indigo-400 py-2 flex flex-col items-center justify-center w-14 sm:w-20">
            <span class="minutes p-2 sm:w-10 text-center bg-indigo-300 text-sm sm:text-lg text-white"></span>
            <div class="sm:text-sm text-xs text-white">Minutes</div>
        </div>
        <div class="bg-indigo-400 py-2 flex flex-col items-center justify-center w-14 sm:w-20">
            <span class="seconds p-2 sm:w-10 text-center bg-indigo-300 text-sm sm:text-lg text-white"></span>
            <div class="sm:text-sm text-xs text-white">Seconds</div>
        </div>
    </div>
    <form action="{{ route('quiz.submit', ['quiz' => $quiz]) }}" method="POST" id="quiz-form">
        @csrf
        @foreach ($quiz->questions as $question)
            <div class="flex flex-col p-3 border-2 border-gray-800 m-4">
                <p class="text-red-600 mb-2">
                    Q{{ $loop->index + 1 }}) {{ $question->body }}
                </p>
                <ol class="flex flex-col ml-5 space-y-2">
                    @foreach ($question->answers as $answer)
                        <li class="flex items-center space-x-2 {{ $answer->is_correct ? 'text-red-400' : '' }}">
                            <span>{{ $loop->index + 1 }}.</span>
                            <input id="{{ $answer->id }}" class="cursor-pointer" type="radio" name="{{ $question->id }}"
                                   value="{{ $answer->id }}">
                            <label for="{{ $answer->id }}" class="cursor-pointer place-self-start">
                                {{ $answer->body }}
                            </label>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endforeach
        <div class="flex justify-center py-5">
            <input type="submit" class="bg-green-400 text-gray-50 p-3 cursor-pointer" value="Submit">
        </div>
    </form>
@endsection


@section('script')
    <script>
        function getTimeRemaining(endtime) {
            var t = Date.parse(endtime) - Date.parse(new Date());
            var seconds = Math.floor((t / 1000) % 60);
            var minutes = Math.floor((t / 1000 / 60) % 60);
            var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
            var days = Math.floor(t / (1000 * 60 * 60 * 24));
            return {
                'total': t,
                'days': days,
                'hours': hours,
                'minutes': minutes,
                'seconds': seconds
            };
        }

        function initializeClock(id, endtime) {
            var clock = document.getElementById(id);
            var daysSpan = clock.querySelector('.days');
            var hoursSpan = clock.querySelector('.hours');
            var minutesSpan = clock.querySelector('.minutes');
            var secondsSpan = clock.querySelector('.seconds');

            function updateClock() {
                var t = getTimeRemaining(endtime);

                daysSpan.innerHTML = t.days;
                hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                if (t.total <= 0) {
                    clearInterval(timeinterval);
                    document.getElementById('quiz-form').submit();
                }
            }

            updateClock();
            var timeinterval = setInterval(updateClock, 1000);
        }

        var deadline = '{{ $quiz->end_at }}';
        // check if quiz has start date or date is past
        // if ({{ $quiz->start_at ? (!$quiz->start_at->isPast() ? true : false) : false }}) {
        if ('{{ $quiz->end_at }}') {
            initializeClock('clockdiv', deadline);
        }
    </script>
@endsection
