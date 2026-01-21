@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container content-with-nav">
    <div style="padding: 1.5rem 0;">
        <h1 style="font-size: 1.5rem; font-weight: 700;">Profile</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Profile Info Card -->
    <div class="card text-center">
        <div style="width: 80px; height: 80px; background: #7604c2;background: linear-gradient(135deg,rgba(118, 4, 194, 1) 0%, rgba(252, 176, 69, 1) 83%);color:white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1rem; color: white;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $user->name }}</h2>
        <p class="text-secondary">{{ $user->email }}</p>
    </div>

    <!-- Update Profile Form -->
    <div class="card">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Update Profile</h3>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <!-- Change Password Form -->
    <div class="card">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Change Password</h3>
        <form method="POST" action="{{ route('profile.changePassword') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>

    <!-- Logout Button -->
    <div class="card">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>

<!-- Bottom Navigation -->
 @include('layouts.bottom-nav')


@endsection
