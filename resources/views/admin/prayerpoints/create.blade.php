@extends('admin.layouts.app')

@section('title', 'Create Prayerpoints')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Create New Quiz</h1>

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

            <form action="{{ route('admin.prayer.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                
              <div class="form-group">
                    <label>Prayer Points</label>
                    <textarea name="prayerpoints" class="form-control" rows="12" required>{{ old('prayerpoints') }}</textarea>
                </div>
                



                <!--<div class="form-group form-check">-->
                <!--    <input type="checkbox" class="form-check-input" id="isActive" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>-->
                <!--    <label class="form-check-label" for="isActive">Publish immediately (Active)</label>-->
                <!--</div>-->

                <button type="submit" class="btn btn-primary">Create Quiz</button>
                <a href="{{ route('admin.prayer.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
