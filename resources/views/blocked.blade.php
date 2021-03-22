@extends('layouts.main')

@section('title', 'Blocked')

@section('content')
    <p>{{ Auth::user()->name }}, you have been blocked.</p>
@endsection