@extends('instructor.shared.main')
@php
$route = route('students.show', ['room' => 2]);
// dd($route);
@endphp
@section('main')
    <div class="md:ml-48">

    </div>
@endsection

{{-- @section('script')
    <script>
        $.getJSON('{{ $route }}').done(function(data, sta) {
            console.log(data);
            $.each(data.items, function(index, item) {
                console.log(item);
            });
        });
    </script>
@endsection --}}
