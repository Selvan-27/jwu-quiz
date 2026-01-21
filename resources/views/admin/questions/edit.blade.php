@extends('admin.layouts.app')

@section('title', 'Edit Question')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Question</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
             @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.quizzes.questions.update', [$quiz->id, $question->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Question Text</label>
                    <textarea name="question_text" class="form-control" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Explanation (Optional - shown after quiz)</label>
                    <textarea name="explanation" class="form-control" rows="2">{{ old('explanation', $question->explanation) }}</textarea>
                </div>
                
                <hr>
                <h5 class="mb-3">Options</h5>
                <p class="small text-muted">Select the radio button next to the correct answer.</p>

                @php
                    $options = $question->options->sortBy('order')->values();
                @endphp

                @for($i = 0; $i < 4; $i++)
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" name="correct_option" value="{{ $i }}" 
                                {{ old('correct_option', $options[$i]->is_correct ?? false) ? 'checked' : '' }} required>
                        </div>
                    </div>
                    <input type="text" name="options[]" class="form-control" placeholder="Option {{ $i + 1 }}" 
                        value="{{ old('options.'.$i, $options[$i]->option_text ?? '') }}" required>
                </div>
                @endfor

                <button type="submit" class="btn btn-primary">Update Question</button>
                <a href="{{ route('admin.quizzes.show', $quiz->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
