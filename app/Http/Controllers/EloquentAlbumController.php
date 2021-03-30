<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EloquentAlbumController extends Controller
{
    public function index() {

        return view('eloquentalbum.index', [
            'albums' =>Album::with('artist')
            ->with('user')
            ->join('artists', 'artists.id', '=', 'albums.artist_id')
            ->join('users', 'users.id', '=', 'albums.user_id')
            ->orderBy('artists.name')
            ->orderBy('title')
            ->get(['artists.id AS artist_id', 'users.id AS user_id', 'albums.*']),
        ]);
    }

    public function create() {
        return view('eloquentalbum.create', [
            'artists' => Artist::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = new Album();
        $album->title = $request->input('title');
        $album->artist()->associate(Artist::find($request->input('artist')));
        $user = User::find(Auth::user()->id);
        $album->user()->associate($user);
        $album->save();

        $artist = Artist::find($request->input('artist'));

        return redirect()
        ->route('eloquentalbum.index')
        ->with('success', "Successfully created {$artist->name} - {$request->input('title')}");
    }

    public function edit($id) {
        $album = Album::find($id);
        $this->authorize('update', $album);
        $artists = Artist::orderBy('name')->get();

        return view('eloquentalbum.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        $album = Album::find($id);
        $this->authorize('update', $album);
        $album->title = $request->input('title');
        $album->artist()->associate(Artist::find($request->input('artist')));
        $album->save();

        $artist = Artist::find($request->input('artist'));

        return redirect()
            ->route('album.edit', [ 'id' => $id ])
            ->with('success', "Successfully updated {$artist->name} - {$request->input('title')}");
    
    }
}
