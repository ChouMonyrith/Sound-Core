<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sound;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SoundController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        $countPending = Sound::where('status', 'pending')->count();
        $user = Auth::user();
        $isAdmin = $user && $user->role === 'admin';

        $sounds = Sound::query()
            ->when($title, function ($query, $title) {
                return $query->where('title', 'like', "%$title%");
            })
            ->when($filter, function ($query, $filter) {
                return $query->whereHas('category', function ($q) use ($filter) {
                    $q->where('name', 'like', "%$filter%");
                });
            })
            ->where('status', 'approved')
            ->with('category')
            ->paginate(10);
        
        return view('sounds.index', compact('sounds', 'title', 'filter','isAdmin','countPending'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Sound::class);
        $categories = Category::all();
        return view('sounds.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Sound::class);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:mp3,wav|max:10240',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // dd($data);

        $data['file_path'] = $request->file('file_path')->store('sounds', 'public');
        $data['image_path'] = $request->file('image_path')->store('images', 'public');
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending'; 

        Sound::create($data);

        return redirect()->route('sounds.index')->with('success', 'Sound uploaded successfully, awaiting approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sound = Sound::findOrFail($id);

        if ($sound->status !== 'approved' && !Gate::allows('manage-sound', $sound)) {
            abort(403);
        }

        return view('sounds.show', compact('sound'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sound = Sound::findOrFail($id);
        $this->authorize('update', $sound);

        $categories = Category::all();
        return view('sounds.edit', compact('sound', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $sound = Sound::findOrFail($id);
        $this->authorize('update', $sound);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:mp3,wav|max:10240',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('file_path')) {
            Storage::disk('public')->delete($sound->file_path);
            $data['file_path'] = $request->file('file_path')->store('sounds', 'public');
        } else {
            $data['file_path'] = $request->old_file_path ?? $sound->file_path;
        }

        if ($request->hasFile('image_path')) {
            Storage::disk('public')->delete($sound->image_path);
            $data['image_path'] = $request->file('image_path')->store('images', 'public');
        } else {
            $data['image_path'] = $request->old_image_path ?? $sound->image_path;
        }

        $sound->update($data);

        return redirect()->route('sounds.index')->with('success', 'Sound updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sound = Sound::findOrFail($id);
        $this->authorize('delete', $sound);

        Storage::disk('public')->delete([$sound->file_path, $sound->image_path]);
        $sound->delete();

        return redirect()->route('sounds.index')->with('success', 'Sound deleted successfully.');
    }

    /**
     * Download an approved sound file.
     */
    public function download($id)
    {
        $sounds = Sound::findOrFail($id);

        if ($sounds->status !== 'approved' && !Gate::allows('manage-sound', $sounds)) {
            abort(403);
        }

        if (Storage::disk('public')->exists($sounds->file_path)) {
            return response()->download(storage_path('app/public/' . $sounds->file_path));
        }

        return redirect()->route('sounds.index')->with('error', 'File not found.');
    }

    /**
     * Approve a sound (Admin only).
     */

    public function pending()
    {
        
        $this->authorize('viewAny',Sound::class);

        $user = Auth::user();
        $isAdmin = $user && $user->role === 'admin';
        
        $sounds = Sound::where('status','pending')->with('category')->paginate(10);

        return view('sounds.pending',compact('sounds'));
    }
    public function approve($id)
    {
        $this->authorize('approve', Sound::class);

        $sounds = Sound::findOrFail($id);
        $sounds->update(['status' => 'approved']);

        return redirect()->route('sounds.index')->with('success', 'Sound approved successfully.');
    }

    public function reject($id){
        
        $this->authorize('reject',Sound::class);

        $sounds = Sound::findOrFail($id);
        $sounds->update(['status' => 'rejected']);

        return redirect()->route('sounds.index')->with('success','Sound rejected successfully');

    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $sound = Sound::findOrFail($id);

       
        $sound->ratings()->updateOrCreate(
            ['user_id' => Auth::id()], 
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        
        $sound->average_rating = $sound->ratings()->avg('rating');
        $sound->save();

        return redirect()->route('sounds.show', $id)->with('success', 'Your rating has been submitted successfully!');
    }
}