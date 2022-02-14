@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Post</h1>
</div>

<div class="col-lg-8 mb-3">
    <form method="POST" action="/dashboard/posts" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title')
                is-invalid
            @enderror" id="title" name="title" autofocus value="{{ old('title') }}">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug')
                is-invalid
            @enderror" id="slug" name="slug" value="{{ old('slug') }}">
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select @error('category_id')
                is-invalid
            @enderror" name="category_id">
                @foreach ($categories as $category)
                @if (old('category_id') == $category->id)
                <option value="{{ $category -> id }}" selected>{{ $category -> name }}</option>
                @else
                <option value="{{ $category -> id }}">{{ $category -> name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Post image</label>
            <img src="" class="img-preview img-fluid mb-3 col-sm-5" alt="">
            <input class="form-control @error('image')
                is-invalid
            @enderror" type="file" id="image" name="image" onchange="previewImage()">
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">body</label>
            @error('body')
            <div class="alert alert-danger alert-dismissible fade show mt2" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
            <trix-editor input="body"></trix-editor>
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>

<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function(){
        fetch('/dashboard/posts/checkSlug?title='+title.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });
    document.addEventListener('trix-file-accept', function(e){
        e.preventDefault();
    })

    // Logika Javascript
    // 1. menyeleksi bagian dalam html yang akan di digunakan dalam js, 
    // 2. Menggunakan fetch , parameter yang ada di dalam fetch adalah url yang digunakan untuk menangani hal tersebut dalam kasus diatas digunakan untuk menangani slug sehingga urlnya ditujukan pada /dashboard/posts/checkSlug (checkSlug adalah sebuah method yang ada pada file DashboardPostController yang digunakan untuk menangani sluggable karena nantinya akan memiliki return slugService)
    // ?title= title.value adalah proses pengiriman data untuk url nantinya
    // .then (response => response.jspn()) adalah sebuah bentuk default dari fetch (berbentuk promise)
    // .then (data ) dan .then(response) adalah susunan default dari fetch (MENURUT SAYA)
    // slug.value diambil dari variable slug yang mengambil nilai dari inputan 
    // data.slug akan diambil dari data yang propertynya bernama slug
    
    // Function Preview image
    function previewImage(){
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>

@endsection