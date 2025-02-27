@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')
    <h2>Create Permission</h2>
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <label for="name">Permission Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Create</button>
    </form>
@endsection
