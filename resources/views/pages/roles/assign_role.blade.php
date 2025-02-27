<h1>Assign Role to User</h1>
<form action="{{ route('users.assignRole', $user->id) }}" method="POST">
    @csrf
    <select name="role" required>
        <option value="">Select Role</option>
        @foreach ($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <button type="submit">Assign Role</button>
</form>
