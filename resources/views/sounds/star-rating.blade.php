<form action="{{ route('sounds.rate', $sound->id) }}" method="POST" class="mt-3">
    @csrf
    <div class="flex items-center">
        <span class="mr-2 text-white">Rate this sound:</span>
        <div class="flex">
            @for ($i = 1; $i <= 5; $i++)
                <input type="radio" id="star{{ $i }}-{{ $sound->id }}" name="rating" value="{{ $i }}" class="hidden peer" {{ (isset($sound->userRating) && $sound->userRating == $i) ? 'checked' : '' }}/>
                <label for="star{{ $i }}-{{ $sound->id }}" class="cursor-pointer text-xl text-gray-400 hover:text-yellow-500 peer-checked:text-yellow-500">
                    &#9733;
                </label>
            @endfor
        </div>
        <button type="submit" class="btn ml-3">Submit</button>
    </div>
</form>