<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('q');
        if ($name)
        {
            return Artist::where('name', 'LIKE', '%'.$name.'%')->get();
        }
        else
        {
            return Artist::all();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        return Artist::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        //select count(*) as total_tracks
        // from tracks
        // inner join albums on albums.id = tracks.album_id
        // inner join artists on artists.id = albums.artist_id
        // where artists.id = 1

        $trackCount = DB::table('tracks')
        ->join('albums', 'albums.id', '=', 'tracks.album_id')
        ->join('artists', 'artists.id', '=', 'albums.artist_id')
        ->where('artist_id', '=', $artist->id)->count();

        if ($trackCount > 0) {
            return response()->json([
                'error' => 'You cannot delete an artist that has tracks.',
            ], 400);
        }

        $artist->delete();
        return response(null, 204);
    }
}
