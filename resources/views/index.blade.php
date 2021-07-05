@extends('shared.main')

@section('main')
    {{-- @dd($rooms) --}}
    <div class="w-5/6 mx-auto mt-5">

        <div class="flex flex-wrap justify-between">
            @foreach ($rooms as $room)
                <div class="lg:w-2/4 lg:max-w-md w-full bg-white shadow-md rounded-md px-6 py-4 my-6">
                    <div class="flex justify-between">
                        <div class="text-2xl text-gray-800">
                            <h2>Room : {{ $room->name }}</h2>
                        </div>
                        <div class="mt-2 sm:mt-0">
                            @php
                                if ($enrolled->contains('room_id', $room->id)) {
                                    $en = true;
                                } else {
                                    $en = false;
                                }
                            @endphp
                            <a class="{{ $en ? 'bg-green-500' : 'bg-blue-600 hover:bg-blue-500' }} 
                                                flex items-center text-white  rounded px-2 py-1  focus:outline-none focus:shadow-outline"
                                href="{{ route('room.show', ['room' => $room->id]) }}">
                                @if (!$en)
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="ml-1 text-sm">
                                        Enroll
                                    </span>
                                @else
                                    <span class="ml-1 text-sm">
                                        Enrolled
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="flex items-center">
                            <div class="text-lg text-gray-800 mr-2">
                                <h2>Instructor : </h2>
                            </div>
                            <img class="h-12 w-12 rounded-full"
                                src="https://ui-avatars.com/api/?name=
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {{ $room->owner->first_name }}+{{ $room->owner->last_name }}"
                                alt="">
                            <div class="ml-2">
                                <h3 class="sm:text-lg text-gray-800 font-medium">{{ $room->owner->first_name }}
                                    {{ $room->owner->last_name }}</h3>
                                <span class="text-gray-600">{{ $room->owner->email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <h4 class="text-gray-600 text-sm">Student Numers</h4>
                            <span class="mt-2 text-xl font-medium text-gray-800">{{ $room->students_number }}</span>
                        </div>
                        <div>
                            <h4 class="text-gray-600 text-sm">Created At</h4>
                            <span
                                class="mt-2 text-sm font-medium text-gray-500">{{ $room->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                </div>
            @endforeach
            {{ $rooms->links() }}
        </div>


    </div>

@endsection
