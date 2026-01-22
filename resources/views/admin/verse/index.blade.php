@extends('admin.layouts.app')

@section('title', 'Manage Memory Verse')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bible Verses to Memorize</h1>
        <a href="{{ route('admin.verse.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Memory Verse
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
                            <!--<th>Status</th>-->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $quiz)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <a href="{{ route('admin.verse.show', $quiz->id) }}" style="font-weight: 600;">
                                    {{ $quiz->title }}
                                </a>
                                <div class="small text-gray-500">{{ Str::limit($quiz->description, 50) }}</div>
                            </td>
                           
                            <!--<td>-->
                            <!--    @if($quiz->is_active)-->
                            <!--        <span class="badge badge-success">Active</span>-->
                            <!--    @else-->
                            <!--        <span class="badge badge-secondary">Draft</span>-->
                            <!--    @endif-->
                            <!--</td>-->
                            <td>
                                <a href="{{ route('admin.verse.show', $quiz->id) }}" class="btn btn-sm btn-primary" title="Manage Memory Verse">
                                    <i class="fas fa-list"></i> show
                                </a>
                                <a href="{{ route('admin.verse.edit', $quiz->id) }}" class="btn btn-sm btn-info" title="Edit Memory Verse">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.verse.destroy', $quiz->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this Memory Verse?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
               
            </div>
        </div>
    </div>
@endsection
