<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function index() {

        $albums = DB::table('albums')
        ->join('artists', 'artists.id', '=', 'albums.artist_id')
        ->orderBy('artist')
        ->orderBy('title')
        ->get([
            'albums.id',
            'albums.title',
            'artists.name AS artist',
        ]);

        return view('album.index', [
            'albums' => $albums,
        ]);
    }

    public function create() {

        $artists = DB::table('artists')->orderBy('name')->get();

        return view('album.create', [
            'artists' => $artists,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        db::table('albums')->insert([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist')
        ]);

        $artist = DB::table('artists')
            ->where('id', '=', $request->input('artist'))
            ->first();

        return redirect()
        ->route('album.index')
        ->with('success', "Successfully created {$artist->name} - {$request->input('title')}");
    }

    public function edit($id) {
        
        $album = DB::table('albums')->where('id', '=', $id)->first();
        $artists = DB::table('artists')->orderBy('name')->get();

        return view('album.edit', [
            'artists' => $artists,
            'album' => $album,
        ]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'title' => 'required|max:50',
            'artist' => 'required|exists:artists,id',
        ]);

        DB::table('albums')->where('id', '=', $id)->update([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist'),
        ]);

        $artist = DB::table('artists')
            ->where('id', '=', $request->input('artist'))
            ->first();

        return redirect()
            ->route('album.edit', [ 'id' => $id ])
            ->with('success', "Successfully updated {$artist->name} - {$request->input('title')}");
    
    }
}
