
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-white">Welcome to Your Dashboard</h1>
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-gray-800 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Total Sounds</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $totalSounds }}</p>
        </div>
        <div class="p-4 bg-gray-800 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-white">Your Uploads</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $userUploads }}</p>
        </div>
    </div>
    <div class="m-4">
        <a href="{{ route('sounds.index') }}" class="btn btn-primary hover:underline items-end hover:border-2 text-white font-bold py-2 px-4 rounded">Back to Sound List</a>
    </div>
</div>
@endsection
