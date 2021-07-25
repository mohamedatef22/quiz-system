@extends('instructor.shared.main')

@section('main')
    <div class="md:ml-48 transition-all duration-500 main p-5">
        <div class="flex items-center justify-center bg-gray-100 font-sans">
            <div class="w-full">
                <div class="flex flex-row-reverse">
                    <a href="{{ route('room.create') }}"
                       class="flex items-center gap-1 bg-blue-500 text-sm text-white p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create Room
                    </a>
                </div>
                <div class="bg-white shadow-md rounded my-6">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left sm:w-2/6">name</th>
                                <th class="py-3 px-6 text-left sm:w-1/6">Students Number</th>
                                <th class="py-3 px-6 text-center sm:w-2/6">Password</th>
                                <th class="py-3 px-6 text-center sm:w-1/6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($rooms as $room)
                                <tr class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            <span class="font-medium">
                                                {{ $room->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $room->students_number }}
                                    </td>

                                    <td class="py-3 px-6 relative">
                                        <input type="text" id="{{ $room->id }}"
                                               class="text-sm rounded-lg bg-gray-200 w-full" value="{{ $room->password }}"
                                               readonly>
                                        <button class="bg-gray-200 absolute top-5 right-10 right- copy"
                                                data-id="{{ $room->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
                                                <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </button>
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="">

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 toolt">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.copy').on('click', function() {
            id = $(this).attr('data-id');
            $(`#${id}`).select();
            succeed = document.execCommand("copy");
            toastr.options = {
                "positionClass": "toast-bottom-right",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
            }
            toastr.success("copied to clipboard");
        });
    </script>
@endsection
