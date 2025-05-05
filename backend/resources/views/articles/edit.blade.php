@extends("layouts.mystyle")
@section("content")



<x-app-layout>


  <div class="flex flex-col items-center w-full overflow-hidden">
  
      <div class="w-full py-12">
          <div class="w-full">
              <div>
                  <div class="flex justify-between">
                      <div v-if="user" class="flex flex-col gap-5 ps-6 py-6">
                          <h1 class="text-3xl tracking-wide uppercase">Edit this Article</h1>
                      </div>
                  </div>

                  <div class="px-6 w-full">

                      <div class="flex justify-start">
                          
                        <form action="{{ route('articles.update', $article->id) }}" enctype="multipart/form-data" method="POST" class="max-w-xl w-full">
                          @csrf
                          @method('PUT')
                        <div class="mb-5">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="title" value="{{ old('title') ?? $article->title }}">
                        </div>
                        <div class="mb-5">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subtitle</label>
                            <input type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="subtitle" value="{{ old('subtitle') ?? $article->subtitle }}">
                        </div>
                        <div class="mb-5">
                            <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                            <textarea type="text" id="base-input" cols="30" rows="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="article" value="{{ old('article') ?? $article->article }}"></textarea>
                        </div>
                        <a>
                          <button type="submit" class="px-4 py-2 mt-4 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">Save</button>
                        </a>
                      
                      </form>
  
                      </div>
                  </div>
  
  
</x-app-layout>
@endsection