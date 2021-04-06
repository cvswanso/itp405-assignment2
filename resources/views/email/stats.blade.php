@extends('layouts.email')

@section('content')
<br>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Current User Stats</h5>
            <p class="card-text">There are currently {{ $artist }} artists.</p>
            <p class="card-text">There are currently {{ $playlist }} playlists.</p>
            <p class="card-text">There are currently {{ $track }} milliseconds of tracks.</p>
        </div>
    </div>
  @endsection