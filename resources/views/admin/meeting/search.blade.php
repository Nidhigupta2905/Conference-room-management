@extends('layouts.admin.app')

@section('content')

    @foreach ($search as $sr)
        <p>{{ $sr->from_time }}</p>

    @endforeach
@endsection
