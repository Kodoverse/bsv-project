@extends('layouts.mystyle')
@section('content')

    <x-app-layout>

        <div id="admin-dashboard"></div>

        <script>
    window.AppData = {
        user: @json($user),
        role: "{{ $user->role }}"
    };
</script>

@vite('resources/js/admin.js')
    </x-app-layout>
@endsection