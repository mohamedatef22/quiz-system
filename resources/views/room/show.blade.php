@extends('shared.main')

@php
// random color for quiz icon
$colors = ['bg-green-500', 'bg-indigo-500', 'bg-red-500', ' bg-blue-500', ' bg-yellow-500', 'bg-purple-500'];
// get list of quiz taken by user
if (Auth::check()) {
    $quizzes_taken = Auth::user()
        ->quizzes()
        ->where('room_id', $room->id)
        ->get();
}
@endphp

@section('main')

    <div class="mx-4 mt-5">
        <div class="flex md:flex-nowrap flex-wrap bg-white shadow-md rounded-md px-6 py-4 my-6">

            <div class="w-full flex-shrink-0 {{ $enrolled ? '' : 'md:w-1/2' }}">

                <div class="{{ $enrolled ? 'flex flex-col items-center mb-10' : '' }}">

                    <div class="flex justify-between">
                        <div class="text-2xl text-gray-800">
                            <h2>Room : {{ $room->name }}
                            </h2>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="flex items-center">
                            <div class="text-lg text-gray-800 mr-2">
                                <h2>Instructor :
                                </h2>
                            </div>
                            <img class="h-12 w-12 rounded-full"
                                 src="https://ui-avatars.com/api/?name={{ $room->owner->first_name }}+{{ $room->owner->last_name }}"
                                 alt="">
                            <div class="ml-2">
                                <h3 class="sm:text-lg text-gray-800 font-medium">
                                    {{ $room->owner->first_name }}
                                    {{ $room->owner->last_name }}
                                </h3>
                                <span class="text-gray-600">{{ $room->owner->email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-10 items-center mt-6">
                        <div>
                            <h4 class="text-gray-600 text-sm">
                                Student Numers
                            </h4>
                            <span class="mt-2 text-xl font-medium text-gray-800">{{ $room->students_number }}</span>
                        </div>
                        <div>
                            <h4 class="text-gray-600 text-sm">
                                Created At
                            </h4>
                            <span
                                  class="mt-2 text-sm font-medium text-gray-500">{{ $room->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- #TODO this code for testing must be deleted --}}

                        <div>
                            <h4 class="text-gray-600 text-sm">
                                Password
                            </h4>
                            <span class="mt-2 text-sm font-medium text-gray-500">{{ $room->password }}</span>
                        </div>
                    </div>

                </div>

                @if ($enrolled)
                    <div class="border-t-4 mt-4 w-full">
                        <div class="flex flex-wrap justify-around mt-5 space-x-1 space-y-4">

                            @foreach ($room->quizzes as $quiz)
                                <div class="lg:w-1/4 md:w-1/3 xl:w-1/5 sm:w-1/2 w-full">
                                    <!-- start card -->
                                    <div
                                         class="flex-shrink-0 relative bg-white py-6 px-6 rounded-3xl w-full my-4 shadow-xl">
                                        <div
                                             class=" text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl {{ $colors[array_rand($colors)] }} left-4 -top-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </div>
                                        <div class="mt-10">
                                            <div class="text-center text-blue-500">

                                                <a class="text-xl font-semibold mb-7"
                                                   href="{{ route('quiz.show', ['quiz' => $quiz->id]) }}">
                                                    {{ $quiz->name }}
                                                </a>
                                            </div>
                                            <div class="flex space-x-2 text-gray-400 text-sm mt-5">
                                                <!-- svg  -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p>
                                                    {{ Carbon\CarbonInterval::minute($quiz->time)->cascade()->forHumans() }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-2 text-gray-400 text-sm my-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                @if ($quiz->start_at)
                                                    <p>
                                                        @if ($quiz->start_at->isPast())
                                                            started
                                                        @else
                                                            Starts in
                                                        @endif
                                                        {{ $quiz->start_at->diffForHumans() }}
                                                    </p>
                                                @else
                                                    <p>You can Take Any time
                                                    </p>
                                                @endif
                                            </div>

                                            @if ($quiz->end_at)
                                                <div class="flex space-x-2 text-gray-400 text-sm my-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <p>
                                                        @if ($quiz->end_at->isPast())
                                                            ended
                                                        @else
                                                            end in
                                                        @endif
                                                        {{ $quiz->end_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="flex space-x-2 text-gray-400 text-sm my-5">
                                                </div>
                                            @endif
                                            <div class="border-t-2">
                                            </div>
                                            {{-- @if (Auth::check()) --}}
                                            @php
                                                $is_taken = $quizzes_taken->find($quiz->id);
                                            @endphp
                                            <div class="flex items-center mt-1">
                                                @if ($is_taken)
                                                    <p class="font-semibold">
                                                        Grade :
                                                    </p>
                                                    <span
                                                          class="inline-flex ml-3 items-center justify-center px-3 py-1 text-xs font-bold leading-none text-red-100 bg-pink-500 rounded-full">{{ $is_taken->quiz->grade }}</span>
                                                    <span
                                                          class="inline-flex items-center absolute top-2 right-2 justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-gray-50 mx-auto bg-green-600 rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Taken
                                                    </span>
                                                @else
                                                    <p class="font-semibold">
                                                        Grade :
                                                    </p>
                                                    <span
                                                          class="inline-flex ml-3 items-center justify-center px-3 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                                        Not taken</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif

            </div>

            @if (!$enrolled && Auth::check())

                {{-- start enroll form --}}
                <div class="border-t-2 md:border-l-4 md:border-t-0 md:w-1/2 w-full">
                    <form class="m-4 flex text-sm" action="{{ route('room.enroll', ['room' => $room->id]) }}"
                          method="POST">
                        @csrf
                        <input value="{{ old('password') }}"
                               class="rounded-l-md p-2 border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white"
                               placeholder="Room Password" type="password" name="password" required />
                        <button
                                class="px-5 rounded-r-lg bg-yellow-400 text-gray-50 hover:bg-yellow-500 uppercase border-yellow-500 border-t border-b border-r">
                            Enroll
                        </button>

                    </form>
                </div>
                {{-- end enroll form --}}

            @elseif(!Auth::check())
                <div
                     class="border-t-2 md:border-l-4 md:border-t-0 md:w-1/2 w-full text-center flex flex-col justify-center">
                    <p class="text-lg text-red-500 pt-4 md:pt-0">
                        You need to login to enroll to this Room
                    </p>
                </div>
            @endif

        </div>


    </div>

@endsection
