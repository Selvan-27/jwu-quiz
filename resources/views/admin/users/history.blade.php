@extends('admin.layouts.app')

@section('title', 'User History')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">History: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Users
        </a>
    </div>

    <!-- User Stats Summary -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Attempts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attempts->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Passed Quizzes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $user->quizAttempts()->get()->filter(function($a) { return ($a->score/$a->total_questions)*100 >= $a->quiz->passing_score; })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Quiz Attempts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Quiz Title</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Result</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attempts as $attempt)
                        @php
                            $percentage = ($attempt->score / $attempt->total_questions) * 100;
                            $passed = $percentage >= $attempt->quiz->passing_score;
                        @endphp
                        <tr>
                            <td>{{ $attempt->quiz->title }}</td>
                            <td>{{ $attempt->score }} / {{ $attempt->total_questions }}</td>
                            <td>
                                <div class="progress mb-1" style="height: 10px;">
                                    <div class="progress-bar {{ $passed ? 'bg-success' : 'bg-danger' }}" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%" 
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>
                                <small>{{ number_format($percentage, 0) }}%</small>
                            </td>
                            <td>
                                @if($passed)
                                    <span class="badge badge-success">Pass</span>
                                @else
                                    <span class="badge badge-danger">Fail</span>
                                @endif
                            </td>
                            <td>{{ $attempt->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('history.show', $attempt->id) }}" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No quiz attempts found for this user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $attempts->links() }}
            </div>
        </div>
    </div>
@endsection
