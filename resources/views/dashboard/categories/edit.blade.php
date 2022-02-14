@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Category</h1>
</div>

<div class="col-lg-8 mb-3">
    <form method="POST" action="/dashboard/categories/{{ $category -> slug }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror" id="name" name="name" required autofocus value="{{ old('name', $category-> name )}}">
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug')
                is-invalid
            @enderror" id="slug" name="slug" required value="{{ old('slug', $category -> slug) }}">
            @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

<script>
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch('/dashboard/categories/checkSlug?name='+name.value)
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