@extends('layouts.app')

@section('content')
    <div class="container border-1 mt-5 mx-auto">
        <x-navigation/>

        <form class="my-4 flex items-center justify-center space-x-2" action="{{ route('sounds.index') }}" method="GET">
            <input class="border-3 bg-white rounded-lg h-10 w-full border-black focus:ring" type="text" name="title" placeholder="Search by Title" value="{{ request('title') }}"/>
            <input type="hidden" name="filter" value="{{ request('filter') }}" />
            <button class="btn border-3 text-white" type="submit">Search</button>
            <a class="btn text-white" href="{{ route('sounds.index') }}">Clear</a>
        </form>

        <div class="mb-4 flex space-x-2 rounded-md bg-gray-900 p-2">
            @php
                $filters = [
                    '' => 'All',
                    'nature' =>  'Nature',
                    'city' => 'City',
                    'animals' => 'Animals',
                    'music' => 'Music',
                    'fire' => 'Fire',
                    'car' => 'Car',
                ];
            @endphp
            @foreach ($filters as $key => $label)
                <a class="{{ request('filter') == $key ? 
                    'flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-lg font-medium bg-white text-black no-underline' 
                    :'bg-black text-white shadow-sm flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-sm font-medium no-underline' }}"
                    href="{{ route('sounds.index', ['filter' => $key, 'title' => request('title')]) }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @can('create-sound')
            <a class="btn mb-6 hover:underline" href="{{ route('sounds.create') }}">
                <i class="fa-solid fa-plus" style="color: #ffffff;"> Add New Sound</i>
            </a>
        @endcan

        @can('viewAny', App\Models\Sound::class)
            <a class="btn ml-4 mb-6 hover:underline" href="{{ route('sounds.pending') }}">
                <i class="fa-solid fa-plus" style="color: #ffffff;">Pending Sounds ( {{ $countPending ?? 0 }} )</i>
            </a>
        @endcan

        @if ($sounds->isEmpty())
            <div class="text-center text-white bg-gray-800 p-4 rounded-md">
                <p class="text-lg">No sounds available.</p>
                <p class="text-sm text-gray-400">Try adding a new sound or adjusting your filters.</p>
            </div>
        @else
            @foreach ($sounds as $sound)
                <div class="sound-item mt-4 p-3 border w-full rounded bg-gray-900 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h5 class="mb-1">{{ $sound->title }}</h5>
                            <p class="mb-0">{{ $sound->artist }}</p>
                            @if($sound->status === 'pending')
                                <span class="text-yellow-500">(Pending Approval)</span>
                            @elseif($sound->status === 'rejected')
                                <span class="text-red-500">(Rejected)</span>
                            @endif
                        </div>
                        <div class="mt-3">
                            <span id="duration-{{ $sound->id }}">
                                {{ gmdate('i:s', (int) $sound->duration) }}
                            </span>
                            <i id="play-icon-{{ $sound->id }}" class="fa-solid fa-play mx-7 cursor-pointer" 
                            onclick="playAudio('audio-{{ $sound->id }}', 'play-icon-{{ $sound->id }}')"></i>
                            <audio id="audio-{{ $sound->id }}" src="{{ asset('storage/' . $sound->file_path) }}"></audio> 
                            <a href="{{ route('sounds.download', ['id' => $sound->id]) }}" class="fa-solid fa-download mr-7"></a> 
                            <a href="{{ route('sounds.show', $sound->id) }}"><i class="fa-solid fa-expand"></i></a>                     
                        </div>
                    </div>

                    @can('manage-sound', $sound)
                        <div class="flex space-x-2 mt-3">
                            <a href="{{ route('sounds.edit', $sound->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('sounds.destroy', $sound->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>
            @endforeach
            <div class="mt-6 flex justify-center">
                <div class="inline-flex space-x-3 bg-gray-800 px-6 py-3 rounded-lg shadow-lg">
                    {{ $sounds->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>            
        @endif
        <x-footer/>
    </div>
@endsection
