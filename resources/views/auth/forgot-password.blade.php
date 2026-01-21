@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container" style="max-width: 400px; margin-top: 2rem;">
    <div class="text-center mb-2">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Forgot Password?</h1>
        <p class="text-secondary">Enter your email to receive a reset link</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus>
            </div>

            <button type="submit" class="btn btn-primary">Send Reset Link</button>

            <div class="text-center mt-2">
                <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none;">Back to Login</a>
            </div>
        </form>
    </div>
</div>
@endsection
