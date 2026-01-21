@extends('layouts.app')

@section('title', 'Quiz Instructions')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="card">
        <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $quiz->title }}</h1>
        <p class="text-secondary" style="margin-bottom: 2rem;">{{ $quiz->description }}</p>

        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">📋 Instructions</h2>

        <div style="background: var(--bg-primary); padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
            <div style="margin-bottom: 0.75rem;">
                <strong>Total Questions:</strong> {{ $quiz->questions->count() }}
            </div>
            <div style="margin-bottom: 0.75rem;">
                <strong>Time Limit:</strong> {{ $quiz->time_limit }} minutes
            </div>
            <div style="margin-bottom: 0.75rem;">
                <strong>Passing Score:</strong> {{ $quiz->passing_score }}%
            </div>
            <div>
                <strong>Marking Scheme:</strong> 1 point per correct answer
            </div>
        </div>

        <div style="background: rgba(79, 70, 229, 0.1); padding: 1rem; border-radius: 10px; border-left: 4px solid var(--primary); margin-bottom: 1.5rem;">
            <p style="margin: 0; font-size: 0.9rem;">
                ⚠️ Once you start the quiz, the timer will begin. Make sure you have a stable internet connection and won't be interrupted.
            </p>
        </div>

        <form method="POST" action="{{ route('quiz.start', $quiz->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary">Start Quiz</button>
        </form>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-1" style="text-decoration: none;">Back to Home</a>
    </div>
</div>
@endsection
