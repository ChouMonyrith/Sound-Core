@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-around items-center w-full border-2 text-white m-4">
        <div class="grid grid-rows-3 gap-4 text-white w-1/2 m-4">
            <div class="row-span-0.5 ">
                <h5 class="mb-1 text-lg">{{ $sound->title }}</h5>
                <p class="mb-1">{{ $sound->artist }}</p>
            </div>
            <div class="row-span-2">
                <textarea class="mt-1 mb-5 block w-full h-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm resize-none" @readonly(true)>
                    {{ $sound->description }}
                </textarea>
            </div>
            <div class="row-span-0.5 mb-4">
            <audio controls class="mt-8 w-full">
                <source src="{{ asset('storage/' . $sound->file_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            </div>
        </div>
        <div class="gap-2 mr-8">  
            <img src="{{ asset('storage/' . $sound->image_path) }}" alt="Sound Image" class=" w-300 h-300 rounded-md">
        </div>
    </div>
    <div class="m-4">
        <a href="{{ route('sounds.index') }}" class="btn btn-primary hover:underline hover:border-2 text-white font-bold py-2 px-4 rounded">Back to Sound List</a>
    </div>
</div>
@endsection