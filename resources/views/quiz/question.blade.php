@extends('layouts.app')

@section('title', 'Question ' . $questionNumber)

@section('content')
<!-- Timer -->
<div class="timer" id="timer">
    <span id="timer-display">{{ $attempt->quiz->time_limit }}:00</span>
</div>

<div class="container" style="padding-top: 5rem; padding-bottom: 2rem;">
    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ ($questionNumber / $questions->count()) * 100 }}%"></div>
    </div>

    <div style="text-align: center; margin-bottom: 1.5rem;">
        <div class="text-secondary" style="font-size: 0.9rem;">Question {{ $questionNumber }} of {{ $questions->count() }}</div>
    </div>

    <div class="card">
        <h2 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1.5rem; line-height: 1.6;">
            {{ $currentQuestion->question_text }}
        </h2>

        <div id="options-container">
            @foreach($currentQuestion->options as $option)
            <div class="option @if($userAnswer && $userAnswer->option_id == $option->id) selected @endif" 
                 data-option-id="{{ $option->id }}"
                 onclick="selectOption({{ $option->id }})">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <div style="flex-shrink: 0; width: 24px; height: 24px; border: 2px solid currentColor; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 0.125rem;">
                        <div class="option-dot" style="width: 12px; height: 12px; border-radius: 50%; background: currentColor; display: none;"></div>
                    </div>
                    <div style="flex: 1;">{{ $option->option_text }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
        @if($questionNumber > 1)
        <a href="{{ route('quiz.question', ['attemptId' => $attempt->id, 'questionNumber' => $questionNumber - 1]) }}" 
           class="btn btn-secondary" style="text-decoration: none;">Previous</a>
        @endif

        @if($questionNumber < $questions->count())
        <a href="{{ route('quiz.question', ['attemptId' => $attempt->id, 'questionNumber' => $questionNumber + 1]) }}" 
           class="btn btn-primary" style="text-decoration: none; flex: 1;">Next</a>
        @else
        <button onclick="showSubmitModal()" class="btn btn-success" style="flex: 1;">Submit Quiz</button>
        @endif
    </div>
</div>

<!-- Submit Confirmation Modal -->
<div class="modal" id="submit-modal">
    <div class="modal-content">
        <div class="modal-title">Submit Quiz?</div>
        <p class="text-secondary">Are you sure you want to submit your quiz? You won't be able to change your answers after submission.</p>
        <div class="modal-buttons">
            <button onclick="hideSubmitModal()" class="btn btn-secondary" style="flex: 1;">Cancel</button>
            <form method="POST" action="{{ route('quiz.submit', $attempt->id) }}" style="flex: 1;">
                @csrf
                <button type="submit" class="btn btn-success">Yes, Submit</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let selectedOptionId = {{ $userAnswer->option_id ?? 'null' }};
    const attemptId = {{ $attempt->id }};
    const questionId = {{ $currentQuestion->id }};
    const timeLimit = {{ $attempt->quiz->time_limit }};
    const startedAt = new Date('{{ $attempt->started_at }}');

    // Timer functionality
    function updateTimer() {
        const now = new Date();
        const elapsed = Math.floor((now - startedAt) / 1000);
        const remaining = (timeLimit * 60) - elapsed;

        if (remaining <= 0) {
            // Time's up - auto submit
            document.querySelector('form[action*="submit"]').submit();
            return;
        }

        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        const display = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        document.getElementById('timer-display').textContent = display;

        const timerElement = document.getElementById('timer');
        if (remaining <= 60) {
            timerElement.classList.add('danger');
        } else if (remaining <= 300) {
            timerElement.classList.add('warning');
        }
    }

    setInterval(updateTimer, 1000);
    updateTimer();

    // Option selection
    function selectOption(optionId) {
        // Remove previous selection
        document.querySelectorAll('.option').forEach(opt => {
            opt.classList.remove('selected');
            opt.querySelector('.option-dot').style.display = 'none';
        });

        // Add new selection
        const selectedOption = document.querySelector(`[data-option-id="${optionId}"]`);
        selectedOption.classList.add('selected');
        selectedOption.querySelector('.option-dot').style.display = 'block';

        selectedOptionId = optionId;

        // Save answer via AJAX
        saveAnswer(optionId);
    }

    // Save answer
    function saveAnswer(optionId) {
        fetch(`/quiz/attempt/${attemptId}/save-answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                question_id: questionId,
                option_id: optionId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Failed to save answer');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Modal functions
    function showSubmitModal() {
        document.getElementById('submit-modal').classList.add('active');
    }

    function hideSubmitModal() {
        document.getElementById('submit-modal').classList.remove('active');
    }

    // Show selected option dot on page load
    document.querySelectorAll('.option.selected').forEach(opt => {
        opt.querySelector('.option-dot').style.display = 'block';
    });
</script>
@endpush
@endsection
