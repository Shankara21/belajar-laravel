@extends('dashboard.layouts.main')
@php

@endphp
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Users</h1>
</div>

<div class="table-responsive col-lg-8">
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <a class="btn btn-primary mb-3 " href="/dashboard/users/create">Create New User</a>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Level</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)

            <tr>
                <td>{{ $loop -> iteration }}</td>
                <td>{{ $user -> name }}</td>
                <td>{{ $user -> username }}</td>
                <td>{{ $user -> email }}</td>
                <td>{{ $user -> is_admin }}</td>
                <td>
                    <a href="/dashboard/users/{{$user->username}}/edit" class="badge bg-warning"><span
                            data-feather="edit"></span></a>
                    <form action="/dashboard/users/{{$user->username}}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        {{-- <a href="/dashboard/posts/destroy" class="badge bg-danger"><span
                                    data-feather="x-circle"></span></a> --}}
                        <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span
                                data-feather="x-circle"></span></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection