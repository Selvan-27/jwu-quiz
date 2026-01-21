@extends('admin.layouts.app')

@section('title', 'Quiz Details')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quiz: {{ $quiz->title }}</h1>
        <div>
            <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-info shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Quiz
            </a>
            <a href="{{ route('admin.quizzes.questions.create', $quiz->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add Question
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Quiz Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Time Limit:</strong> {{ $quiz->time_limit }} minutes
                </div>
                <div class="col-md-3">
                    <strong>Passing Score:</strong> {{ $quiz->passing_score }}%
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong> 
                    @if($quiz->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-secondary">Draft</span>
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Total Questions:</strong> {{ $quiz->questions->count() }}
                </div>
            </div>
            <hr>
            <p><strong>Description:</strong> {{ $quiz->description }}</p>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Questions</h6>
        </div>
        <div class="card-body">
            @if($quiz->questions->isEmpty())
                <p class="text-center text-gray-500 my-4">No questions added yet.</p>
            @else
                <div class="accordion" id="questionsAccordion">
                    @foreach($quiz->questions as $question)
                        <div class="card mb-2">
                            <div class="card-header d-flex justify-content-between align-items-center" id="heading{{ $question->id }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse{{ $question->id }}">
                                        Q{{ $loop->iteration }}: {{ Str::limit($question->question_text, 80) }}
                                    </button>
                                </h2>
                                <div>
                                    <a href="{{ route('admin.quizzes.questions.edit', [$quiz->id, $question->id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.quizzes.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div id="collapse{{ $question->id }}" class="collapse" data-parent="#questionsAccordion">
                                <div class="card-body">
                                    <p><strong>Question:</strong> {{ $question->question_text }}</p>
                                    <p><strong>Explanation:</strong> {{ $question->explanation ?? 'None' }}</p>
                                    
                                    <h6 class="font-weight-bold mt-3">Options:</h6>
                                    <ul class="list-group">
                                        @foreach($question->options as $option)
                                            <li class="list-group-item {{ $option->is_correct ? 'list-group-item-success' : '' }}">
                                                {{ $option->option_text }}
                                                @if($option->is_correct)
                                                    <span class="badge badge-success float-right">Correct</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
