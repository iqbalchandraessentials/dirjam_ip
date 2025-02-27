@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')
<h1>Create Role</h1>
<form action="{{ route('roles.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Role Name" required>
    <button type="submit">Save</button>
</form>

@endsection