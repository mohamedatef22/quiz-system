@extends('instructor.shared.main')

@section('main')
    <div class="md:ml-48 transition-all duration-500 main">
        <div class="flex justify-center items-center bg-gray-100 font-sans mt-20">
            <form method="POST" action="{{ route('room.store') }}" class="sm:w-1/2 w-full sm:px-0 px-2">
                @csrf

                <!-- First Name -->
                <div>
                    <label for="first-name">Room Name</label>

                    <input id="name" class="block mt-1 w-full text-sm rounded-md" type="text" name="name"
                           value="{{ old('name') }}" required autofocus />
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="mt-4">
                    <label for="last-name">Password</label>

                    <div class="flex space-x-3">
                        <input id="password" class="block mt-1 w-2/3 text-sm rounded-md" type="text" name="pass"
                               value="{{ old('pass') }}" required autofocus />
                        <button id="random" type="button" class="bg-green-500 text-white text-xs px-2 rounded-md">
                            Generate random pass
                        </button>
                    </div>
                    @error('pass')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-center mt-16">
                    <button type="submit" class="bg-blue-600 text-sm text-white p-3">Create Room</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        url = 'http://localhost:8000/api/random/password' // #FIXME need to replace with .env file
        $('#random').click(function() {
            $.getJSON(url).done(function(data) {
                $('#password').val(data.password);
            });
        });
    </script>
@endsection
