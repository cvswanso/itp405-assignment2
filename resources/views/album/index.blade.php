@extends('layouts.main')

@section('title', 'Albums')

@section('content')
    <div class="text-end mb-3">
        <a href="{{ route('album.create') }}">New Album</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Album</th>
                <th>Artist</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($albums as $album)
                <tr>
                    <td>
                        {{ $album->title }}
                    </td>
                    <td>
                        {{ $album->artist }}
                    </td>
                    <td>
                        <a href="{{ route('album.edit', ['id' => $album->id]) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection