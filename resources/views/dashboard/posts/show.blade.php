@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <div class="row my-3">
        <div class="col-lg-8">
            <h1>{{ $post -> title}}</h1>
            <a href="/dashboard/posts" class="btn btn-secondary"><span data-feather="corner-down-left"></span> Back to
                all my posts</a>
            <a href="/dashboard/posts/{{ $post -> slug }}/edit" class="btn btn-warning"><span
                    data-feather="edit"></span> Edit</a>
            <form action="/dashboard/posts/{{ $post -> slug }}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                {{-- <a href="/dashboard/posts/destroy" class="badge bg-danger"><span
                                            data-feather="x-circle"></span></a> --}}
                <button class="btn btn-danger" onclick="return confirm('Are you sure?')"> <span
                        data-feather="x-circle"></span> delete</button>
            </form>
            {{-- <a href="" class="btn btn-danger"><span data-feather="x-circle"></span> delete</a> --}}
            @if ($post -> image)
            <div class="" style="max-height: 400px; overflow: hidden;">
                <img class="img-fluid mt-3" src="{{ asset('storage/'.$post -> image) }}" alt="">
            </div>
            @else
            <img class="img-fluid mt-3" src="https://source.unsplash.com/1200x400?{{ $post -> category -> name }}"
                alt="">
            @endif

            <p class="mt-3">Category : {{ $post -> category -> name }}</p>
            <article class="my-3 fs-6">
                {!! $post -> body !!}
            </article>
        </div>
    </div>
</div>
@endsection