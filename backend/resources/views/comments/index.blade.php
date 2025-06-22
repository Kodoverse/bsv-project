@extends('layouts.mystyle')
@section('content')

    <x-app-layout>


        <div class="flex flex-col items-center w-full overflow-hidden">

            <div class="w-full py-12">
                <div class="w-full">
                    <div>
                        <div class="flex justify-between">
                            <div v-if="user" class="flex flex-col gap-5 ps-6 py-6">
                                <h1 class="text-3xl tracking-wide uppercase">All Comments</h1>
                            </div>
                        </div>

                        <div class="px-6 w-full">
                            <div class="mx-auto grid">
                                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                    <div class="text-gray-900 dark:text-gray-100">
                                        <div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
                                            <table
                                                class="text-sm w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                <thead
                                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3">
                                                            Comment
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Created
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Article Id
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                            Is Flagged
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($comments as $comment)


                                                        <tr
                                                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">

                                                            
                                                            <td class="px-6 py-4">
                                                                {{ $comment->comment }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $comment->created_at }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $comment->article_id }}
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                {{ $comment->is_flagged }}
                                                            </td>
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