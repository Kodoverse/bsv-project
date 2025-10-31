@props([
    'title' => null,
    'subtitle' => null,
    'breadcrumbs' => null,
    'backUrl' => null,
])

@extends('layouts.admin')

@section('content')
    
    @isset($title)
        <x-page-header :title="$title" :subtitle="$subtitle" />
    @endisset

    @isset($breadcrumbs)
        <x-subnav :breadcrumbs="$breadcrumbs" :backUrl="$backUrl" />
    @endisset

    <section class="p-6">
        {{ $slot }}
    </section>

@endsection