@extends('admin.layouts.app')

@section('title', 'Manage Quizzes')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quizzes</h1>
        <a href="{{ route('admin.quizzes.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Quiz
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <!--<th>Time Limit</th>-->
                            <!--<th>Pass Score</th>-->
                            <th>Questions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                        <tr>
                              <td>{{$loop->iteration}}</td>
                            <td>
                                
                                <a href="{{ route('admin.quizzes.show', $quiz->id) }}" style="font-weight: 600;">
                                    {{ $quiz->title }}
                                </a>
                                <div class="small text-gray-500">{{ Str::limit($quiz->description, 50) }}</div>
                            </td>
                            <!--<td>{{ $quiz->time_limit }} min</td>-->
                            <!--<td>{{ $quiz->passing_score }}%</td>-->
                            <td>{{ $quiz->questions_count }}</td>
                            <td>
                                @if($quiz->is_active)
                                    <span class="badge badge-success">Publish</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.quizzes.show', $quiz->id) }}" class="btn btn-sm btn-primary" title="Manage Questions">
                                    <i class="fas fa-list"></i>
                                </a>
                                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-info" title="Edit Quiz">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this quiz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection
