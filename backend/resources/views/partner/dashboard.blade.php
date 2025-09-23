@extends('layouts.mystyle')
@section('content')

    <x-app-layout>

        <div id="partner-dashboard"></div>

        <script>
    window.AppData = {
        user: @json($user),
        role: "{{ $user->role }}"
    };
</script>

@vite('resources/js/partner.js')
    </x-app-layout>
@endsection