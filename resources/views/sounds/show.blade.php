{{-- filepath: c:\Users\rithc\OneDrive\Desktop\php-Program\SoundCatalog\sound-catalog\resources\views\sounds\show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-around items-center w-full border-2 text-white m-4">
        <div class="grid grid-rows-3 gap-4 text-white w-1/2 m-4">
            <div class="row-span-0.5 ">
                <h5 class="mb-1 text-lg">{{ $sound->title }}</h5>
                <p class="mb-1">{{ $sound->artist }}</p>
                <p class="mt-2 text-sm text-gray-400">
                    Average Rating: 
                    @if ($sound->average_rating)
                        <span class="text-yellow-500 text-lg">{{ number_format($sound->average_rating, 1) }} &#9733;</span>
                    @else
                        <span class="text-gray-500">No ratings yet</span>
                    @endif
                </p>
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

    {{-- Rating and Comment Form --}}
    <div class="mt-8">
        <h3 class="text-lg font-bold text-white">Rate and Comment</h3>
        <form action="{{ route('sounds.rate', $sound->id) }}" method="POST" class="mt-6">
            @csrf
            <label for="rating" class="mr-4 text-white">Rate this sound:</label>
            <div class="flex mb-4">
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" />
                    <label for="star{{ $i }}" class="cursor-pointer text-xl text-yellow-400 hover:text-gray-500 peer-checked:text-gray-500">
                        &#9733;
                    </label>
                @endfor
            </div>
            <textarea name="comment" rows="3" class="w-full p-2 rounded-md bg-gray-800 text-white border-gray-600 focus:ring focus:ring-indigo-500" placeholder="Write your comment here..." required></textarea>
            <button type="submit" class="btn btn-primary hover:underline items-end hover:border-2 text-white font-bold py-2 px-4 rounded mt-4">Post</button>
        </form>
    </div>

    {{-- Display Existing Ratings and Comments --}}
    <div class="mt-8">
        <h3 class="text-lg font-bold text-white">Comments</h3>
        <div class="mt-4">
            @forelse ($sound->ratings as $rating)
                <div class="mb-4 p-4 bg-gray-800 rounded-md">
                    <p class="text-sm text-gray-300"><strong>{{ $rating->user->name }}</strong> rated:</p>
                    <p class="text-yellow-500">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $rating->rating ? '★' : '☆' }}
                        @endfor
                    </p>
                    @if ($rating->comment)
                        <p class="text-white mt-2">{{ $rating->comment }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">{{ $rating->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-500">No ratings or comments yet. Be the first to rate and comment!</p>
            @endforelse
        </div>
    </div>

    <div class="m-4">
        <a href="{{ route('sounds.index') }}" class="btn btn-primary hover:underline items-end hover:border-2 text-white font-bold py-2 px-4 rounded">Back to Sound List</a>
    </div>
</div>
@endsection