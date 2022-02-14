@extends('layouts.main')

@section('container')
<div class="row d-flex justify-content-center">
    <div class="col-md-5">
        <main class="form-signin">
            <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>
            <form action="/register" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input required type="text" class="form-control @error('name')
                        is-invalid
                    @enderror" id="name" placeholder="Name" name="name" value="{{ old('name') }}">
                    <label for="name">Name</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input required type="text" class="form-control @error('username')
                        is-invalid
                    @enderror" id="username" placeholder="Username" name="username" value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input required type="email" name="email" class="form-control @error('email')
                        is-invalid
                    @enderror" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
                    <label for="floatingInput">Email address</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input required type="password" name="password" class="form-control @error('password')
                        is-invalid
                    @enderror" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
            </form>
            <small class="d-block text-center mt-3">Already registered? <a href="/login">Login!</a></small>
        </main>
    </div>
</div>

@endsection