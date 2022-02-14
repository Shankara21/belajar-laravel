@extends('layouts.main')
@section('container')
    <h1>{{ $name }}</h1>
    <h2>{{ $email }}</h2>
    <img src="img/{{ $foto }}" alt="" width="250px" title="{{ $name }}">
@endsection
