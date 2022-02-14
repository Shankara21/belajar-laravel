@extends('layouts.main')

@section('container')
<div class="row d-flex justify-content-center">
    <div class="col-lg-5">
        {{-- menggunakan kondisi apabila dalam registerController terdapat 'success' maka akan menjalankan sebuah alert --}}
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{-- menampilkan pesan yang ada didalam flash --}}
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{-- menampilkan pesan yang ada didalam flash --}}
            {{ session('loginError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <main class="form-signin">
            <h1 class="h3 mb-3 fw-normal text-center">Please Log in</h1>
            <form action="/login" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input name="email" type="email" class="form-control @error('email')
                        is-invalid
                    @enderror" id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                    <label for="email">Email address</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Log in</button>
            </form>
            <small class="d-block text-center mt-3">Not registered? <a href="/register">Register Now!</a></small>
        </main>
    </div>
</div>

@endsection