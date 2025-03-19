@extends('layouts.app')

@section('content')
<div class="container m-4 p-4">
    <form action="{{ route('sounds.update', $sound->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="flex justify-around items-center w-full border-2 text-white m-4">
            <div class="grid grid-rows-3 gap-4 text-white w-1/2 m-4">
                <!-- Title -->
                <div class="row-span-0.5">
                    <label for="title" class="block text-sm font-medium text-white">Title</label>
                    <input type="text" name="title" id="title" value="{{ $sound->title }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black">
                </div>

                <!-- Artist -->
                <div class="row-span-0.5">
                    <label for="artist" class="block text-sm font-medium text-white">Artist</label>
                    <input type="text" name="artist" id="artist" value="{{ $sound->artist }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black">
                </div>

                <!-- Description -->
                <div class="row-span-2">
                    <label for="description" class="block text-sm font-medium text-white">Description</label>
                    <textarea name="description" id="description"
                              class="mt-1 block w-full h-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black resize-none">{{ $sound->description }}</textarea>
                </div>

                <div class="row-span-2 my-4">
                    <label for="category_id" class="block text-sm font-medium text-white">Category</label>
                    <select name="category_id" id="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $sound->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Audio File -->
                <div class="row-span-0.5">
                    <label for="file_path" class="block text-sm font-medium text-white">Audio File</label>
                    @if($sound->file_path)
                        <audio controls class="mt-2 w-full">
                            <source src="{{ asset('storage/' . $sound->file_path) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @endif
                    <input type="file" name="file_path" id="file_path" accept=".mp3,.wav"
                           class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-white">
                    <!-- Retain Old File -->
                    <input type="hidden" name="old_file_path" value="{{ $sound->file_path }}">
                </div>
            </div>

            <!-- Image -->
            <div class="gap-2 mr-8">
                <label for="image_path" class="block text-sm font-medium text-white">Image</label>
                @if($sound->image_path)
                    <img src="{{ asset('storage/' . $sound->image_path) }}" alt="Sound Image" class="w-64 h-64 rounded-md mt-2">
                @endif
                <input type="file" name="image_path" id="image_path" accept=".jpeg,.png,.jpg"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-white">
                <!-- Retain Old Image -->
                <input type="hidden" name="old_image_path" value="{{ $sound->image_path }}">       
            </div>
            
        </div>


        <!-- Submit Button -->
        <div class="m-4">
            <button type="submit" class="btn btn-primary hover:underline hover:border-2 text-white font-bold py-2 px-4 rounded">
                Update Sound
            </button>
            <a href="{{ route('sounds.index') }}" class="btn btn-secondary hover:underline hover:border-2 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
