@extends('admin.layouts.app')

@section('title', 'Detailed Report')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Report: {{ $quiz->title }}</h1>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Overview
        </a>
    </div>

    <!-- Quiz Summary Card -->
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Attempts</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $quiz->attempts()->count() }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pass Score</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $quiz->passing_score }}%</div>
                </div>
                <!--<div class="col-md-3">-->
                <!--    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Avg Score</div>-->
                <!--    <div class="h5 mb-0 font-weight-bold text-gray-800">-->
                <!--        {{ $quiz->attempts()->count() }}-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Time Limit</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $quiz->time_limit }} mins</div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Attempts Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All User Attempts</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="datatable">
                   <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <!--<th>Result</th>-->
                            <th>Time Taken</th>
                            <th>Date</th>
                            <!--<th>Actions</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attempts as $attempt)
                        @php
                        $totalQuestions = $attempt->total_questions ?? 0;

$percentage = $totalQuestions > 0
    ? ($attempt->score / $totalQuestions) * 100
    : 0;

$passingScore = $quiz->passing_score ?? 0;
$passed = $percentage >= $passingScore;

                        @endphp
                        <tr>
                              <td>{{$loop->iteration}}</td>
                            <td>{{ $attempt->user->name }}</td>
                            <td>{{ $attempt->user->email }}</td>
                            <td><strong>{{ $attempt->score }}</strong> / {{ $attempt->total_questions }}</td>
                            <td>
                                <div class="progress mb-1" style="height: 10px;">
                                    <div class="progress-bar {{ $passed ? 'bg-success' : 'bg-danger' }}" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%" 
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>
                                <!--<small>{{ number_format($percentage, 0) }}%</small>-->
                            </td>
                            <!--<td>-->
                            <!--    @if($passed)-->
                            <!--        <span class="badge badge-success">Pass</span>-->
                            <!--    @else-->
                            <!--        <span class="badge badge-danger">Fail</span>-->
                            <!--    @endif-->
                            <!--</td>-->
                            <td>{{ gmdate('H:i:s', $attempt->time_taken) }}</td>
                            <td>{{ $attempt->created_at->format('M d, Y H:i') }}</td>
                            <!--<td>-->
                            <!--    <a href="{{ route('history.show', $attempt->id) }}" class="btn btn-sm btn-info" target="_blank" title="View Detailed Answers">-->
                            <!--        <i class="fas fa-eye"></i> Details-->
                            <!--    </a>-->
                            <!--</td>-->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No attempts found for this quiz.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            
        </div>
    </div>
@endsection
