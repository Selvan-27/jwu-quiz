@extends('layouts.app')

@section('title', 'Review Answers')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Answer Review</h1>
    <p class="text-secondary" style="margin-bottom: 2rem;">{{ $attempt->quiz->title }}</p>

    @foreach($attempt->quiz->questions as $index => $question)
        @php
            $userAnswer = $attempt->userAnswers->where('question_id', $question->id)->first();
            $correctOption = $question->options->where('is_correct', true)->first();
        @endphp

        <div class="card" style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div style="font-weight: 600; color: var(--text-secondary);">Question {{ $index + 1 }}</div>
                @if($userAnswer && $userAnswer->is_correct)
                    <span class="badge badge-success">✓ Correct</span>
                @else
                    <span class="badge badge-danger">✗ Incorrect</span>
                @endif
            </div>

            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1.5rem; line-height: 1.6;">
                {{ $question->question_text }}
            </h3>

            <div>
                @foreach($question->options as $option)
                    @php
                        $isUserAnswer = $userAnswer && $userAnswer->option_id == $option->id;
                        $isCorrect = $option->is_correct;
                    @endphp

                    <div class="option 
                        @if($isCorrect) correct @endif
                        @if($isUserAnswer && !$isCorrect) incorrect @endif
                        @if($isUserAnswer) selected @endif"
                        style="cursor: default;">
                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                            <div style="flex-shrink: 0; margin-top: 0.125rem;">
                                @if($isCorrect)
                                    <span style="color: var(--success); font-size: 1.25rem;">✓</span>
                                @elseif($isUserAnswer)
                                    <span style="color: var(--danger); font-size: 1.25rem;">✗</span>
                                @else
                                    <span style="opacity: 0.3;">○</span>
                                @endif
                            </div>
                            <div style="flex: 1;">{{ $option->option_text }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($question->explanation)
            <div style="background: rgba(79, 70, 229, 0.1); padding: 1rem; border-radius: 10px; margin-top: 1rem; border-left: 4px solid var(--primary);">
                <div style="font-weight: 600; margin-bottom: 0.5rem; font-size: 0.9rem;">💡 Explanation</div>
                <p style="margin: 0; font-size: 0.9rem; line-height: 1.6;">{{ $question->explanation }}</p>
            </div>
            @endif
        </div>
    @endforeach

    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="text-decoration: none;">Back to Home</a>
</div>
@endsection
