@extends('layouts.main')

@section('container')
<h1 class="mb-3 text-center">{{ $title }}</h1>

{{-- Search --}}
<div class="row justify-content-center mb-3">
    <div class="col-md-6">
        <form action="/blog">
            @if (request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('author'))
            <input type="hidden" name="auhtor" value="{{ request('author') }}">
            @endif
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search"
                    value="{{ request('search') }}">
                <button class="btn btn-warning" type="submit"><img src="img/search.png" alt="" width="20px"></button>
            </div>
        </form>
    </div>
</div>

@if ($posts->count() > 0)
<div class="card mb-3">
    @if ($posts[0] -> image)
    <div class="" style="max-height: 400px; overflow: hidden;">
        <img class="img-fluid " src="{{ asset('storage/'.$posts[0] -> image) }}" alt="">
    </div>
    @else
    <img class="img-fluid " src="https://source.unsplash.com/1200x400?{{ $posts[0] -> category -> name }}" alt="">
    @endif
    <div class="card-body text-center">
        <h3 class="card-title"><a class="text-decoration-none text-dark"
                href="/post/{{ $posts[0]->slug }}">{{ $posts[0] -> title }}</a></h3>
        <p>
            <small>
                By. <a href="/blog?author={{ $posts[0]->author->username }}"
                    class="text-decoration-none">{{ $posts[0] -> author -> name }}</a> in
                <a class="text-decoration-none"
                    href="/blog?category={{ $posts[0] -> category -> slug }}">{{ $posts[0] -> category -> name }}</a>

                <span
                    {{-- Diff for humans adalah sebuah method yang digunakan untuk menghitung perbedaan waktu yang ada dengan waktu sekarang agar mudah dibaca --}}
                    class="text-muted"> {{ $posts[0] -> created_at->diffForHumans() }}</span>
            </small>
        </p>
        <p class="card-text">{{ $posts[0] -> excerpt }}</p>
        <a href="/post/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read more</a>
    </div>
</div>


{{-- Post Card --}}
<div class="container">
    <div class="row">
        @foreach ($posts->skip(1) as $post)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="position-absolute px-3 py-2 text-white" style="background-color: rgba(0, 0, 0, 0.7)"><a
                        class="text-decoration-none text-white" href="/blog?category={{ $post -> category -> slug }}">
                        {{ $post -> category -> name }}</a></div>
                @if ($post -> image)

                <img class="img-fluid " src="{{ asset('storage/'.$post -> image) }}" alt="">
                @else
                <img class="img-fluid " src="https://source.unsplash.com/1200x400?{{ $post -> category -> name }}"
                    alt="">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p>
                        <small>
                            By. <a href="/blog?author={{ $post->author->username }}"
                                class="text-decoration-none">{{ $post -> author -> name }}</a> <span
                                {{-- Diff for humans adalah sebuah method yang digunakan untuk menghitung perbedaan waktu yang ada dengan waktu sekarang agar mudah dibaca --}}
                                class="text-muted"> {{ $post-> created_at->diffForHumans() }}</span>
                        </small>
                    </p>
                    <p class="card-text">{{ $post->excerpt }}</p>
                    <a href="/post/{{ $post->slug}}" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<p class="text-center fs-4">No Post found.</p>
@endif
<div class="d-flex justify-content-end">
    {{ $posts -> links() }}
</div>
@endsection