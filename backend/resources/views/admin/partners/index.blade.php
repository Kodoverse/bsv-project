@extends('layouts.admin')
@section('content')

        <x-app-layout>
        <x-page-header
    title="I partner"

/>

<div>
    @foreach ($partners as $partner )
    <div>{{ $partner->partnerInfo->name }}</div>
    
    @endforeach
</div>


    </x-app-layout>

@endsection