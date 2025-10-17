@extends('layouts.admin')
@section('content')

    <x-app-layout>


        <div class="flex flex-col items-center w-full overflow-hidden">
            <div class="w-full py-12">
                <div class="w-full">
                    <div>
                        <div class="flex justify-between">
                            <div v-if="user" class="flex flex-col gap-5 py-6 ps-6">
                                <h1 class="text-3xl tracking-wide uppercase dark:text-white">Modifica un partner</h1>
                            </div>
                        </div>

                        <div class="w-full px-6">

                            <div class="flex justify-start">

                                <form action="{{ route('admin.partners.update', $partner->id) }}"
                                    method="POST" class="w-full max-w-xl">
                                    @csrf
                                    @method('PUT')
                                    <h3 class="mb-5 text-red-500">Partner Info</h3>
                                    <div class="mb-5">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome
                                            Partner</label>
                                        <input type="text" id="name" value="{{ old('name', $partner->partnerInfo->name) }}"

                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') is-invalid 
                                  @enderror"
                                            name="name">
                                        @error('name')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-5">
                                        <label for="lastname"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cognome
                                            Partner</label>
                                        <input type="text" id="lastname" value="{{ old('lastname') ?? $partner->partnerInfo->lastname }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('lastname') is-invalid 
                                  @enderror"
                                            name="lastname">
                                        @error('lastname')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Indrizzo
                                            Email Partner</label>
                                        <input type="email" id="email" value="{{ old('email') ?? $partner->partnerInfo->email }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') is-invalid 
                                  @enderror"
                                            name="email">
                                        @error('email')
                                            <div class="mt-1 text-sm text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    @if ($errors->any())
                                        <div class='text-red-700'>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <button type="submit"
                                        class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">Create</button>
                                    <a href="{{ route('events.index') }}"></a>

                                </form>

                            </div>
                        </div>


    </x-app-layout>

@endsection
