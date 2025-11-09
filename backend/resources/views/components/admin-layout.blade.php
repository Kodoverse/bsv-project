@props([
    'title' => null,
    'subtitle' => null,
    'breadcrumbs' => null,
    'backUrl' => null,
])

@extends('layouts.admin')

@section('content')
    
@if (!empty($title))
    <x-page-header 
        :title="$title"
        :subtitle="is_object($subtitle) 
            ? 'Sottocategoria di ' . ($subtitle->name ?? '') 
            : $subtitle"
    />
@endif

    @isset($breadcrumbs)
        <x-subnav :breadcrumbs="$breadcrumbs" :backUrl="$backUrl" />
    @endisset

    <section class="p-6">
        {{ $slot }}
    </section>

@endsection