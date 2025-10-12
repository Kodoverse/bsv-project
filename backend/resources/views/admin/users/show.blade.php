@extends('layouts.mystyle')
@section('content')

    <x-app-layout>
        @dd($userData);
        <div class="text-white">{{ $userData }}</div>
    </x-app-layout>
@endsection