@extends('layouts.app')

@section('title', 'Quiz History')

@section('content')
<div class="container content-with-nav">
    <div style="padding: 1.5rem 0;">
        <h1 style="font-size: 1.5rem; font-weight: 700;">My Results</h1>
        <p class="text-secondary">Track your quiz performance</p>
    </div>

    @forelse($attempts as $attempt)
        @php
            $percentage = ($attempt->score / $attempt->total_questions) * 100;
            $passed = $percentage >= $attempt->quiz->passing_score;
        @endphp

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; flex: 1;">{{ $attempt->quiz->title }}</h3>
                <span class="badge @if($passed) badge-success @else badge-danger @endif">
                    @if($passed) PASSED @else FAILED @endif
                </span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <div class="text-secondary" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Score</div>
                    <div style="font-weight: 700; font-size: 1.25rem;">{{ number_format($percentage, 0) }}%</div>
                </div>
                <div>
                    <div class="text-secondary" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Correct</div>
                    <div style="font-weight: 600; color: var(--success);">{{ $attempt->score }}/{{ $attempt->total_questions }}</div>
                </div>
                <div>
                    <div class="text-secondary" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Time</div>
                    <div style="font-weight: 600;">{{ gmdate('i:s', $attempt->time_taken) }}</div>
                </div>
            </div>

            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1rem;">
                📅 {{ $attempt->completed_at->format('M d, Y • h:i A') }}
            </div>

            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('quiz.review', $attempt->id) }}" class="btn btn-primary" style="text-decoration: none; flex: 1;">Review</a>
                <a href="{{ route('history.show', $attempt->id) }}" class="btn btn-secondary" style="text-decoration: none; flex: 1;">Details</a>
            </div>
        </div>
    @empty
        <div class="card text-center">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">No Quiz History</h3>
            <p class="text-secondary" style="margin-bottom: 1.5rem;">You haven't completed any quizzes yet.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="text-decoration: none;">Take a Quiz</a>
        </div>
    @endforelse

    @if($attempts->hasPages())
        <!-- pagination -->
        <div style="margin-top: 1.5rem;margin-bottom: 10rem;">
          {{ $attempts->links('pagination::bootstrap-5') }}
        </div>
        
    @endif
</div>

<!-- Bottom Navigation -->

 @include('layouts.bottom-nav')
 
@endsection
