@extends('layouts.app')

@section('title', 'Quiz Result')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="card text-center">
        <div style="font-size: 4rem; margin-bottom: 1rem;">
            @if($passed)
                🎉
            @else
                📚
            @endif
        </div>

        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">
            @if($passed)
                Congratulations!
            @else
                Keep Learning!
            @endif
        </h1>

        <p class="text-secondary" style="margin-bottom: 2rem;">{{ $attempt->quiz->title }}</p>

        <!-- Score Display -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem;">
            <div style="font-size: 3rem; font-weight: 700; margin-bottom: 0.5rem;">
                {{ $attempt->score }} / {{ $attempt->total_questions }}
            </div>
            <div style="font-size: 1.5rem; opacity: 0.9;">
                {{ number_format($percentage, 1) }}%
            </div>
        </div>

        <!-- Result Details -->
        <div style="background: var(--bg-primary); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; text-align: left;">
                <div>
                    <div class="text-secondary" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Status</div>
                    <div style="font-weight: 600;">
                        <span class="badge @if($passed) badge-success @else badge-danger @endif">
                            @if($passed) PASSED @else FAILED @endif
                        </span>
                    </div>
                </div>
                <div>
                    <div class="text-secondary" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Time Taken</div>
                    <div style="font-weight: 600;">{{ gmdate('i:s', $attempt->time_taken) }}</div>
                </div>
                <div>
                    <div class="text-secondary" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Correct</div>
                    <div style="font-weight: 600; color: var(--success);">{{ $attempt->score }}</div>
                </div>
                <div>
                    <div class="text-secondary" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Incorrect</div>
                    <div style="font-weight: 600; color: var(--danger);">{{ $attempt->total_questions - $attempt->score }}</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <a href="{{ route('quiz.review', $attempt->id) }}" class="btn btn-primary" style="text-decoration: none; margin-bottom: 0.75rem;">
            Review Answers
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="text-decoration: none;">
            Back to Home
        </a>
    </div>
</div>
@endsection
