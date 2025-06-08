@extends('layouts.mystyle')
@section('content')

<x-app-layout>

    
    <div class="flex flex-col items-center w-full overflow-hidden">
        
    
        <div class="w-full py-12">
            <div class="w-full">
                <div>
                    <div class="flex justify-between">
                        <div v-if="user" class="flex flex-col gap-5 py-6 ps-6">
                            <h1 class="text-3xl tracking-wide uppercase">Flagged Comments</h1>
                        </div>
                    </div>
    
                    <div class="w-full px-6">
                        <div class="grid mx-auto">
                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="text-gray-900 dark:text-gray-100">
                                    <div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
                                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Comment
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Reason
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        User
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Time
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($flagged_comments as $comment )
                                                <tr class="border-b border-gray-200 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                                        <th class="px-6 py-4">
                                                            {{$comment->comments}}
                                                        </th>
                                                        <td>
                                                            {{$comment->reason}}
                                                        </td>
                                                        <td>
                                                            {{$comment->user_id}}
                                                        </td>
                                                        <td>
                                                            {{$comment->created_at}}
                                                        </td>
                                                        <td></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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