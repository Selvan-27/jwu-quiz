@extends('admin.layouts.app')

@section('title', 'Quiz Reports')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quiz Reports & Analytics</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Performance Overview</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" id="datatable">
                    <thead>
                        <tr>
                            <th>Quiz Title</th>
                            <th>Total Attempts</th>
                            <th>Avg User. Attend Quiz</th>
                            <!--<th>Pass Rate</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $data)
                        <tr>
                            <td>
                                <a href="{{ route('admin.reports.show', \App\Models\Quiz::where('title', $data['title'])->first()->id) }}" style="font-weight: 600;">
                                    {{ $data['title'] }}
                                </a>
                            </td>
                            <td>{{ $data['total_attempts'] }}</td>
                            <td>{{ $data['avg_score'] }} %</td>
                              <td> <a href="{{ route('admin.reports.show', \App\Models\Quiz::where('title', $data['title'])->first()->id) }}" class="btn btn-sm btn-primary" title="Manage Questions">
                                    <i class="fas fa-list"></i> Reports
                                </a>
                                </td>
                            
                             
                                
                            <!--<td>-->
                            <!--    <div class="progress mb-2">-->
                            <!--        <div class="progress-bar {{ $data['pass_rate'] > 70 ? 'bg-success' : ($data['pass_rate'] > 40 ? 'bg-warning' : 'bg-danger') }}" -->
                            <!--             role="progressbar" -->
                            <!--             style="width: {{ $data['pass_rate'] }}%" -->
                            <!--             aria-valuenow="{{ $data['pass_rate'] }}" -->
                            <!--             aria-valuemin="0" -->
                            <!--             aria-valuemax="100"></div>-->
                            <!--    </div>-->
                            <!--    {{ $data['pass_rate'] }}%-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    @if($data['total_attempts'] == 0)-->
                            <!--        <span class="badge badge-secondary">No Data</span>-->
                            <!--    @elseif($data['pass_rate'] >= 70)-->
                            <!--        <span class="badge badge-success">Excellent</span>-->
                            <!--    @elseif($data['pass_rate'] >= 50)-->
                            <!--        <span class="badge badge-warning">Average</span>-->
                            <!--    @else-->
                            <!--        <span class="badge badge-danger">Needs Improvement</span>-->
                            <!--    @endif-->
                            <!--</td>-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
