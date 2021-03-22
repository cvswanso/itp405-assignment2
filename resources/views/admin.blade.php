@extends('layouts.main')

@section('title', 'Admin')

@section('content')
<form action="{{ route('admin.update') }}" method="POST">
    @csrf
    <div class="mb-3">
        @if ($admin && $admin->value == true)
        <input type="checkbox" id="maintenance-mode" name="maintenance-mode" value="maintenance-mode" checked="checked">
        @else
        <input type="checkbox" id="maintenance-mode" name="maintenance-mode" value="maintenance-mode">
        @endif
        <label for="maintenance-mode"> Maintenance Mode</label><br>
    </div>
    <button type="submit" class="btn btn-primary">
        Save
    </button>
</form>
@endsection