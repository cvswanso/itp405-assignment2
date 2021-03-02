{{ $artist->name}}

@foreach ($artist->albums as $album)
    <div>
        {{$album->id}} - {{ $album->title }}
    </div>
@endforeach