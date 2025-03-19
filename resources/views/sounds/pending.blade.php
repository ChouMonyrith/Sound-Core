@extends('layouts.app')

@section('content')

@foreach($sounds as $sound)
    <div class="sound-item mt-4 p-3 border w-full rounded">
        <div class="flex flex-inline justify-between align-items-center">
            <div class="text-white">
                <h5 class="mb-1">{{ $sound->title }}</h5>
                <p class="mb-0">{{ $sound->artist }}</p>
                @if($sound->status === 'pending')
                    <span class="text-yellow-500">(Pending Approval)</span>
                @elseif($sound->status === 'rejected')
                    <span class="text-red-500">(Rejected)</span>
                @endif
            </div>
            <div class="text-white mt-3">
                <span id="duration-{{ $sound->id }}">
                    {{ gmdate('i:s', (int) $sound->duration) }}
                </span>
                <i id="play-icon-{{ $sound->id }}" class="fa-solid fa-play mx-7" 
                   onclick="playAudio('audio-{{ $sound->id }}', 'play-icon-{{ $sound->id }}')"></i>
                <audio id="audio-{{ $sound->id }}" src="{{ asset('storage/' . $sound->file_path) }}"></audio> 
                <a href="{{ route('sounds.download', ['id' => $sound->id]) }}" class="fa-solid fa-download mr-7"></a> 
                <a href="{{route('sounds.show',$sound->id)}}"><i class="fa-solid fa-expand"></i></a>                     
            </div>
        </div>

        @if($sound->status === 'pending')
            <div class="flex space-x-2 mt-2">
                <!-- Approve Form -->
                <form action="{{ route('sounds.approve', $sound->id) }}" method="POST">
                    @csrf
                    @method('PATCH') <!-- Spoof the PATCH method -->
                    <button type="submit" class="btn btn-success bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                        Approve
                    </button>
                </form>

                <!-- Reject Form -->
                <form action="{{ route('sounds.reject', $sound->id) }}" method="POST">
                    @csrf
                    @method('PATCH') <!-- Spoof the PATCH method -->
                    <button type="submit" class="btn btn-danger bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Reject
                    </button>
                </form>
            </div>
        @endif
    </div>
@endforeach

{{ $sounds->links() }}
    
@endsection