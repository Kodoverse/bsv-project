@extends('layouts.mystyle')
@section('content')

<x-app-layout>


    <div class="flex flex-col items-center w-full overflow-hidden">
    
        <div class="w-full py-12">
            <div class="w-full">
                <div>
                    <div class="flex justify-between">
                        <div v-if="user" class="flex flex-col gap-5 ps-6 py-6">
                            <h1 class="text-3xl tracking-wide uppercase">My products</h1>
                        </div>
                    </div>
    
                    <div class="px-6 w-full">
                        <div class="mx-auto grid">
                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="text-gray-900 dark:text-gray-100">
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
                                                        product
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($products as $product)
                                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                   
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{$product->title}}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ $product->subtitle }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $product->product }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                    <a href="{{ route('products.show', $product->id) }}" rel="noopener noreferrer">
                                                        <button class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                                            More Details
                                                        </button>
                                                    </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{ route('products.create') }}" rel="noopener noreferrer">
                                            <button class="m-5 px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                                Add product
                                            </button>
                                         </a>
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
