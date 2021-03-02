<ul>
    @foreach ($tracks as $track)
        <li>
            {{ $track->name }}
            {{ $track->album->title }}
        </li>
    @endforeach
</ul>
    