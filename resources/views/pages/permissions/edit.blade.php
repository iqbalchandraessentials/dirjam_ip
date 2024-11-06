@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')
    <h2>Edit Permission</h2>
    <form action="{{ route('permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Permission Name:</label>
        <input type="text" name="name" value="{{ $permission->name }}" required>
        <button type="submit">Update</button>
    </form>
@endsection
    