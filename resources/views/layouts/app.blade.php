<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body class="font-sans antialiased bg-gray-900">
        <div class="min-h-screen">
            <main>
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path d="M14.348 14.849a1 1 0 0 1-1.414 0L10 11.414l-2.93 2.93a1 1 0 1 1-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 1 1 1.414-1.414l2.93 2.93 2.93-2.93a1 1 0 1 1 1.414 1.414l-2.93 2.93 2.93 2.93a1 1 0 0 1 0 1.414z"/>
                            </svg>
                        </button>
                    </div>
                @endif
            
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path d="M14.348 14.849a1 1 0 0 1-1.414 0L10 11.414l-2.93 2.93a1 1 0 1 1-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 1 1 1.414-1.414l2.93 2.93 2.93-2.93a1 1 0 1 1 1.414 1.414l-2.93 2.93 2.93 2.93a1 1 0 0 1 0 1.414z"/>
                            </svg>
                        </button>
                    </div>
                @endif
            
                @yield('content')

            </main>
        </div>
        <script>
            let currentlyPlaying = null;
        
            function playAudio(audioId, iconId, durationId) {
                const audioElement = document.getElementById(audioId);
                const playIcon = document.getElementById(iconId);
                const durationElement = document.getElementById(durationId);
        
                if (!audioElement) {
                    console.error("Audio element not found:", audioId);
                    return;
                }
        
                // Stop any currently playing audio
                if (currentlyPlaying && currentlyPlaying !== audioElement) {
                    currentlyPlaying.pause();
                    currentlyPlaying.currentTime = 0; // Reset to start
                    updateDurationCountdown(currentlyPlaying, document.getElementById('duration-' + currentlyPlaying.id.split('-')[1]));
                    
                    const previousIcon = document.querySelector('.fa-pause');
                    if (previousIcon) {
                        previousIcon.classList.remove('fa-pause');
                        previousIcon.classList.add('fa-play');
                    }
                }
        
                if (audioElement.paused) {
                    audioElement.play();
                    playIcon.classList.remove('fa-play');
                    playIcon.classList.add('fa-pause');
                    currentlyPlaying = audioElement;
                    updateDurationCountdown(audioElement, durationElement);
                } else {
                    audioElement.pause();
                    playIcon.classList.remove('fa-pause');
                    playIcon.classList.add('fa-play');
                    currentlyPlaying = null;
                }
            }
        
            function updateDurationCountdown(audioElement, durationElement) {
                const update = () => {
                    if (audioElement.ended) {
                        durationElement.textContent = formatTime(0); // Reset when finished
                        return;
                    }
                    const remainingTime = audioElement.duration - audioElement.currentTime;
                    durationElement.textContent = formatTime(remainingTime);
                    if (!audioElement.paused && !audioElement.ended) {
                        requestAnimationFrame(update);
                    }
                };
                requestAnimationFrame(update);
            }
        
            function formatTime(seconds) {
                if (isNaN(seconds) || seconds < 0) return '0:00'; 
                const minutes = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
            }
        
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('audio[id^="audio-"]').forEach(audio => {
                    const audioId = audio.id;
                    const durationId = 'duration-' + audioId.split('-')[1];
                    const durationElement = document.getElementById(durationId);
        
                    if (!audio || !durationElement) return;
                    durationElement.textContent = formatTime(audio.duration);
                    // Set duration once metadata is loaded
                    audio.addEventListener('loadedmetadata', function() {
                        durationElement.textContent = formatTime(audio.duration);
                    });

       
                    audio.addEventListener('timeupdate', function() {
                        const remainingTime = audio.duration - audio.currentTime;
                        durationElement.textContent = formatTime(remainingTime);
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                setTimeout(() => {
                    document.querySelectorAll('.bg-green-100, .bg-red-100').forEach(msg => {
                        msg.style.transition = 'opacity 0.5s';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500);
                    });
                }, 3000); 
            });
        </script>
    </body>
</html>
