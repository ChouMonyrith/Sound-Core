<?php 

namespace App\Http\Controllers;

use App\Models\Sound;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSounds = Sound::count();
        $userUploads = Sound::where('user_id', Auth::id())->count();
        $averageRating = Sound::where('user_id', Auth::id())->avg('average_rating');
        
        return view('dashboard', compact('totalSounds', 'userUploads', 'averageRating'));
    }
}