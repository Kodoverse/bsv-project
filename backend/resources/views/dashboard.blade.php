@extends('layouts.mystyle')
@section('content')
<x-app-layout>

    
    <div class="flex flex-col items-center w-full overflow-hidden">

        <div class="w-full py-12">
            <div class="w-full">
                <div>
                    <div class="flex justify-between">
                        <div v-if="user" class="flex flex-col gap-5 ps-6 py-6">
                            <h1 class="text-3xl tracking-wide uppercase">My dashboard</h1>
                        </div>
                    </div>

                    <div class="px-6 w-full">
                        <div class="mx-auto  grid grid-cols-4 gap-6">
                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("Notifiche") }}
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("Visitatori") }}
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("Mi piace") }}
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("Commenti") }}
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="p-6 w-full">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div class="grid grid-cols-1 lg:grid-cols-1">
                                <div
                                class="p-6 rounded-md my-shadow bg-gray-800"
                                >
                                    <h2 class="mb-5 text-2xl uppercase">Your Credentials</h2>
                                    <div v-if="user">
                                        <div class="flex items-center justify-between gap-5">
                                            <ul class="flex flex-col gap-2">
                                                <li class="text-sm uppercase">
                                                Mattia Morriale
                                                </li>
                                                <li class="text-sm uppercase">ma</li>
                                                <li class="text-sm uppercase">dark</li>
                                                <li class="text-sm uppercase">
                                                
                                                </li>
                                                <li class="text-sm uppercase">
                                                
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-1">
                                <div
                                class="p-6 rounded-md my-shadow bg-gray-800"
                                >
                                    <div class="flex items-start justify-between mb-4">
                                        <h2 class="mb-5 text-2xl">ORDERS</h2>
                                    </div>
                                </div>
                                <div
                                class="p-6 rounded-md my-shadow bg-gray-800"
                                >
                                    <div class="flex items-start justify-between mb-4">
                                        <h2 class="mb-5 text-2xl uppercase">Your Consultations</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection