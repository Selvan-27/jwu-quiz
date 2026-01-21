@extends('layouts.app')

@section('title', 'Quiz App')

@section('content')
<style>
    .splash-screen {
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .logo {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .app-name {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .loading {
        margin-top: 2rem;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<div class="splash-screen">
    <div class="logo">
        <!--📝-->
        <img src="/jwu.png" style="width:180px; border-radius:25px;">
        </div>
    
    <div class="app-name">Bible Quiz</div>
    <div class="loading">
        <div class="spinner"></div>
    </div>
</div>

<script>
    setTimeout(() => {
        @auth
            window.location.href = '/dashboard';
        @else
            window.location.href = '/login';
        @endauth
    }, 2000);
</script>
@endsection
