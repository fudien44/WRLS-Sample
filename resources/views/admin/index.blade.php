<!-- resources/views/admin/index.blade.php -->

@extends('layouts.auth')

@section('content')
<div class="container">
    <h1>Unverified Users</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.verify', $user->id) }}" method="POST">
                            @csrf
                            <select name="role" required>
                                @foreach (Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success">Verify and Assign Role</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No unverified users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
