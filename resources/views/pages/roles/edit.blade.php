@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')

<h1>Edit Role</h1>
<form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $role->name }}" required>
    <button type="submit">Update</button>
</form>

@endsection