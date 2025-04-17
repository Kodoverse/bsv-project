@extends("layouts.mystyle")
@section("content")

<form action="{{ route('tags.update', $tag->id) }}" enctype="multipart/form-data" method="POST" class="max-w-sm mx-auto">
    @csrf
    @method('PUT')
  <div class="mb-5">
      <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
      <input type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="name" value="{{ old('name') ?? $tag->name }}">
  </div>
  <a>
    <button type="submit">Save</button>
  </a>

</form>
@endsection