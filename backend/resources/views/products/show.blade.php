@extends("layouts.mystyle")
@section("content")


<x-app-layout>

    
    <div class="flex flex-col items-center w-full overflow-hidden">

        <div class="w-full py-12">
            <div class="w-full">
                <div>
                    <div class="flex justify-between">
                        <div v-if="user" class="flex flex-col gap-5 ps-6 py-6">
                            <h1 class="text-3xl tracking-wide uppercase">{{$product->title}}</h1>
                            <h3 class="text-lg tracking-wide uppercase">{{$product->subtitle}}</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex gap-6">   
                                <a href="{{ route('products.edit', $product->id) }}">
                                    <button class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">Edit</button>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
                            </form>
                            </div>
                            
                            
                        </div>
                    </div>
                    
                    <div class="px-6 w-full">
                        <div class="mx-auto  grid grid-cols-3 gap-6">
                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("Like") }}
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("View") }}
                                </div>
                            </div>

                            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                <div class="p-6 flex justify-between text-gray-900 dark:text-gray-100">
                                    {{ __("Comments Count") }}
                                    <h3 class="text-3xl">{{count($product->comments)}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 w-full">
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div class="grid grid-cols-1 lg:grid-cols-1">
                                <div class="p-6 rounded-md my-shadow bg-gray-800">
                                    <h2 class="mb-5 text-2xl">Text</h2>
                                    <p>{{$product->product}}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div
                                class="p-6 rounded-md my-shadow bg-gray-800"
                                >
                                    <div class="flex flex-col items-start justify-between mb-4">
                                        <h2 class="mb-5 text-2xl">Comments</h2>

                                        <table class="text-sm w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">
                                                        Comment
                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Comment's Like
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($product->comments as $comment)
                                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                
                                                    <td class="px-6 py-4">
                                                        @if (isset($comment->comment))
                                                        {{ $comment->comment }}
                                                        {{ $comment->id }}
                                                        @else
                                                        {{ $comment->predefinite_comment }}
                                                        {{ $comment->id }}
                                                        @endif
                                                    </td>

                                                    <td class="px-6 py-4">
                                                        {{$comment->like}}
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