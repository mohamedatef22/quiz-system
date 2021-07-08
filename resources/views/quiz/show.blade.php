@extends('shared.main')

@php
$start = !$quiz->start_at || ($quiz->start_at && $quiz->start_at->isPast());
$end = $quiz->end_at && $quiz->end_at->isPast();

$is_count_down = $quiz->start_at;
$is_taken = App\Http\Controllers\QuizController::isQuizTaken(Auth::user()->id, $quiz->id, false, true);
@endphp
@section('main')
    <div class="flex flex-col items-center bg-white shadow-md rounded-md mt-10 p-5">
        <h1 class="text-3xl text-red-600">{{ $quiz->name }}</h1>
        <p class="text-sm mt-3">
            <span class="font-semibold text-lg text-red-600">Instructions : </span> {{ $quiz->instruction }}
        </p>
        <div class="flex text-gray-500 items-center mt-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm mx-2">Quiz time : </span>
            {{ Carbon\CarbonInterval::minute($quiz->time)->cascade()->forHumans() }}
        </div>
        @if (!$start && $is_count_down)

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

        @endif
        @if ($is_taken)
            <div class="text-lg font-semibold p-2 mt-2">
                Grade : <span class="text-sm bg-purple-500 text-white p-1">{{ $is_taken }}</span>
            </div>
            <div class="text-red-500 text-lg border-2 border-red-400 p-2 mt-5">
                Quiz Has Been Taken Can't take it again !
            </div>
        @elseif($end)
            <div class="text-red-500 text-lg border-2 border-red-400 p-2 mt-5">
                Quiz Has Been Ended Can't take it !
            </div>
        @else
            <a href="{{ route('quiz.take', ['quiz' => $quiz->id]) }}" id="quiz-start"
               class="bg-green-500 p-3 mt-3 text-gray-100 block {{ $start && !$end ? '' : 'hidden' }}">Start
                Quiz</a>
        @endif
    </div>
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
                    document.getElementById('quiz-start').classList.remove('hidden')
                }
            }

            updateClock();
            var timeinterval = setInterval(updateClock, 1000);
        }

        var deadline = '{{ $quiz->start_at }}';
        // check if quiz has start date or date is past
        // if ({{ $quiz->start_at ? (!$quiz->start_at->isPast() ? true : false) : false }}) {
        if ('{{ !$start && !$end }}') {
            initializeClock('clockdiv', deadline);
        }
    </script>
@endsection
