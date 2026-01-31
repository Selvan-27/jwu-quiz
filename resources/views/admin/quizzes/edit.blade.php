@extends('admin.layouts.app')

@section('title', 'Edit Quiz')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Quiz</h1>

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

            <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Quiz Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $quiz->title) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control"  value="{{ old('date', $quiz->date) }}" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $quiz->description) }}</textarea>
                </div>
                
             
                

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Time Limit (minutes)</label>
                            <input type="number" name="time_limit" class="form-control" value="{{ old('time_limit', $quiz->time_limit) }}" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Passing Score (%)</label>
                            <input type="number" name="passing_score" class="form-control" value="{{ old('passing_score', $quiz->passing_score) }}" min="0" max="100" required>
                        </div>
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="isActive" name="is_active" value="1" {{ old('is_active', $quiz->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">Publish immediately (Active)</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Quiz</button>
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
