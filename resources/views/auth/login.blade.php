@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="max-width: 400px; margin-top: 2rem;">
    <div class="text-center mb-2">
        <!--<div style="font-size: 3rem; margin-bottom: 1rem;">📖</div>-->
        
        <!--<div style="font-size: 3rem;">-->
            <img src="/jwu.png" style="width:180px; border-radius:25px;">
         <!--</div>-->
         
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Welcome Back</h1>
        <p class="text-secondary">Sign in to continue your Bible Quiz</p>
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
        <form method="POST" action="{{ route('login') }}">
           @csrf

            <div class="form-group">
                <label class="form-label">Mobile Number</label>
                <input type="number" name="email" class="form-input" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')
    <div class="text-danger">{{ $message }}</div>
@enderror

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            
            @error('password')
    <div class="text-danger">{{ $message }}</div>
@enderror

            <!--<div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">-->
            <!--    <input type="checkbox" name="remember" id="remember">-->
            <!--    <label for="remember" style="margin: 0; font-weight: normal;">Remember me</label>-->
            <!--</div>-->

            <button type="submit" class="btn btn-primary">Login</button>

            <div class="text-center mt-2">
                <a href="{{ route('password.request') }}" style="color: var(--primary); text-decoration: none;">Forgot Password?</a>
            </div>
        </form>
    </div>

    <div class="text-center mt-2">
        <p class="text-secondary"><a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Register new account</a></p>
    </div>
</div>
@endsection
