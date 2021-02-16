<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = DB::table('playlists')
            ->get([
                'playlists.id',
                'playlists.name',
            ]);

        return view('playlist.index', [
            'playlists' => $playlists
        ]);
    }

    public function show($id)
    {
        $playlist = DB::table('playlists')
            ->where('id', '=', $id)
            ->first();

        $playlistTracks = DB::table('playlist_track')
            ->where('playlist_id', '=', $id)
            ->join('tracks', 'tracks.id', '=', 'playlist_track.track_id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->join('genres', 'tracks.genre_id', '=', 'genres.id')
            ->get([
                'tracks.name',
                'artists.name AS artist',
                'albums.title as album',
                'genres.name AS genre',
            ]);

        return view('playlist.show', [
            'playlist' => $playlist,
            'playlistTracks' => $playlistTracks,
        ]);
    }

    public function edit($id) {
        
        $playlist = DB::table('playlists')->where('id', '=', $id)->first();

        return view('playlist.edit', [
            'playlist' => $playlist,
        ]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'name' => 'required|max:30|unique:playlists,name',
        ]);

        $playlist = DB::table('playlists')->where('id', '=', $id)->first();

        DB::table('playlists')->where('id', '=', $id)->update([
            'name' => $request->input('name')
        ]);

        return redirect()
            ->route('playlist.index', [ 'id' => $id ])
            ->with('success', "{$playlist->name} was successfully renamed to {$request->input('name')}");
    
    }
}