@extends('dashboard.layouts.main')
@php
$no = 1;
@endphp
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Post Categories</h1>
</div>

<div class="table-responsive col-lg-6">
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <a class="btn btn-primary mb-3 " href="/dashboard/categories/create">Create New Category</a>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Category Slug</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)

            <tr>
                <td>{{ $loop -> iteration }}</td>
                <td>{{ $category -> name }}</td>
                <td>{{ $category -> slug }}</td>

                <td>
                    <a href="/dashboard/categories/{{ $category -> slug }}/edit" class="badge bg-warning"><span
                            data-feather="edit"></span></a>
                    <form action="/dashboard/categories/{{ $category -> slug }}" method="POST" class="d-inline">
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