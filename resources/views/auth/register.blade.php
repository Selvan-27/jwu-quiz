@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container" style="max-width: 400px; margin-top: 2rem;">
    <div class="text-center mb-2">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Create Account</h1>
        <p class="text-secondary">Join us today and grow through Bible quizzes.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
    
       @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="card">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
            </div>
                <div class="form-group">
                <label class="form-label">Mobile</label>
                <input type="number" name="mobile" class="form-input" value="{{ old('mobile') }}" required>
            </div>


            <!--<div class="form-group">-->
            <!--    <label class="form-label">Email</label>-->
            <!--    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>-->
            <!--</div>-->

            <div class="form-group">
                <label class="form-label">Create Own Password</label>
                <input type="text" name="password" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <div class="text-center mt-2">
        <p class="text-secondary">Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Login</a></p>
    </div>
</div>
@endsection
