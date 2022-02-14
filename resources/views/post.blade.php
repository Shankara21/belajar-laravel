@extends('layouts.main')


@section('container')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <h1>{{ $tes -> title}}</h1>
            <p>By. <a href="/blog?author={{ $tes->author->username }}"
                    class="text-decoration-none">{{ $tes->author->name }}</a>
                in
                <a class=" text-decoration-none"
                    {{-- $tes -> category -> slug, cara agar post mengambil data dari category adalah dengan membuat relasi sehingga category yang diketikkan adalah memanggil method yang telah dibuat di file Model milik post--}}
                    href="/blog?category={{ $tes -> category -> slug }}">{{ $tes -> category -> name }}</a>
            </p>
            @if ($tes -> image)
            <div class="" style="max-height: 400px; overflow: hidden;">
                <img class="img-fluid" src="{{ asset('storage/'.$tes -> image) }}" alt="">
            </div>
            @else
            <img class="img-fluid" src="https://source.unsplash.com/1200x400?{{ $tes -> category -> name }}" alt="">
            @endif
            <article class="my-3 fs-6">
                {!! $tes -> body !!}
            </article>
        </div>
    </div>
</div>
<article>

</article>

@endsection