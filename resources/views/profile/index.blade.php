@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <p>Hello, {{ $user->name }}. Your email is {{ $user->email }}.</p>
@endsection