@extends('layouts.mystyle')
@section('content')

    <x-app-layout>
        @foreach ($users as $user )
            <div class="text-white">{{$user->email}}</div>
        @endforeach
    </x-app-layout>
@endsection