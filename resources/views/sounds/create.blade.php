@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 text-black">
        <h1 class="mb-4 text-2xl font-bold text-white">Add Your Sound</h1>
        <form action="{{ route('sounds.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="block text-sm font-medium text-white">Title</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="block text-sm font-medium text-white">Artist</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="artist" name="artist" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="block text-sm font-medium text-white">Genre</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="genre" name="genre" required>
            </div>
            <div class="mb-3">
                <label for="description" class="block text-sm font-medium text-white">Description</label>
                <textarea class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="duration" class="block text-sm font-medium text-white">Duration</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="duration" name="duration" value="00:00" >
            </div>
            <div class="mb-3">
                <label for="file_path" class="block text-sm font-medium text-white">Sound File</label>
                <input type="file" class="mt-1 block w-full rounded-md text-white border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="file_path" name="file_path" required>
            </div>
            <div class="mb-3">
                <label for="image_path" class="block text-sm font-medium text-white">Sound Cover</label>
                <input type="file" class="mt-1 block w-full rounded-md text-white border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="image_path" name="image_path" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="block text-sm font-medium text-white">Category</label>
                <select class="mt-1 block w-full  rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add Sound</button>
        </form>
    </div>
@endsection