@extends('admin.layouts.app')

@section('title', 'Edit Memory Verse')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Memory Verse</h1>

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

            <form action="{{ route('admin.verse.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $data->title) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Verse</label>
                    <textarea name="description" class="form-control" rows="12" required>{{ old('description', $data->description) }}</textarea>
                </div>
                
           
                <!--<div class="form-group form-check">-->
                <!--    <input type="checkbox" class="form-check-input" id="isActive" name="is_active" value="1" {{ old('is_active', $data->is_active) ? 'checked' : '' }}>-->
                <!--    <label class="form-check-label" for="isActive">Publish immediately (Active)</label>-->
                <!--</div>-->

                <button type="submit" class="btn btn-primary btn-block">Update Memory Verse</button>
                <!-- <a href="{{ route('admin.verse.index') }}" class="btn btn-secondary">Cancel</a> -->
            </form>
        </div>
    </div>
@endsection
