<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index() {

        $tracks = DB::table('tracks')
        ->join('albums', 'albums.id', '=', 'tracks.album_id')
        ->join('artists', 'artists.id', '=', 'albums.artist_id')
        ->join('media_types', 'media_types.id', '=', 'tracks.media_type_id')
        ->join('genres', 'genres.id', '=', 'tracks.genre_id')
        ->orderBy('artist')
        ->orderBy('name')
        ->get([
            'tracks.name',
            'albums.title AS album',
            'artists.name AS artist',
            'media_types.name AS media_type',
            'genres.name AS genre',
            'tracks.unit_price'
        ]);

        return view('track.index', [
            'tracks' => $tracks,
        ]);
    }

    public function new() {

        $albums = DB::table('albums')->orderBy('title')->get();
        $media_types = DB::table('media_types')->orderBy('name')->get();
        $genres = DB::table('genres')->orderBy('name')->get();

        return view('track.new', [
            'albums' => $albums,
            'media_types' => $media_types,
            'genres' => $genres,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'album' => 'required|exists:albums,id',
            'media_type' => 'required|exists:media_types,id',
            'genre' => 'required|exists:genres,id',
            'unit_price' => 'required|numeric',
        ]);

        db::table('tracks')->insert([
            'name' => $request->input('name'),
            'album_id' => $request->input('album'),
            'media_type_id' => $request->input('media_type'),
            'genre_id' => $request->input('genre'),
            'unit_price' =>$request->input('unit_price')
        ]);

        return redirect()
        ->route('track.index')
        ->with('success', "The track {$request->input('name')} was successfully created");
    }
}
