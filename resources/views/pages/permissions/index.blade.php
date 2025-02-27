@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')
    <h2>Permission List</h2>
    <a href="{{ route('permissions.create') }}" class="btn btn-primary">Add New Permission</a>
    <ul>
        @foreach($permissions as $permission)
            <li>
                {{ $permission->name }}
                <a href="{{ route('permissions.edit', $permission) }}">Edit</a>
                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
