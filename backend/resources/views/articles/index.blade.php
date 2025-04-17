@extends('layouts.mystyle')
@section('content')

<div class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
    <table class="text-sm w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Subtilte
                </th>
                <th scope="col" class="px-6 py-3">
                    Article
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($articles as $article)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
               
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$article->title}}
                </th>
                <td class="px-6 py-4">
                    {{ $article->subtitle }}
                </td>
                <td class="px-6 py-4">
                    {{ $article->article }}
                </td>
                <td class="px-6 py-4">
                <a href="{{ route('articles.show', $article->id) }}" target="_blank" rel="noopener noreferrer">
                    <button class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                        More Details
                    </button>
                </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('articles.create') }}" target="_blank" rel="noopener noreferrer">
                    <button class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-indigo-700">
                        Add Article
                    </button>
     </a>
</div>
@endsection