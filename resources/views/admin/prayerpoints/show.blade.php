@extends('admin.layouts.app')

@section('title', 'Prayer Details')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quiz: {{ $data->title }}</h1>
        <div>
            
           
        </div>
    </div>

 

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prayer Points</h6>
        </div>
        <div class="card-body">
           @if(empty($data->prayerpoints))
                <p class="text-center text-gray-500 my-4">No Prayer Points added yet.</p>
            @else
                <div class="accordion" id="questionsAccordion">
                        <div class="card mb-2">
                            <div class="card-header d-flex justify-content-between align-items-center" >
                                <h2 class="mb-0">

                                    <button class="btn btn-block text-left collapsed"  data-toggle="collapse" >
                                       {!! nl2br(e($data->prayerpoints)) !!}
                                    </button>
                                </h2>
                               
                            </div>

                           
                        </div>
                </div>
            @endif
        </div>
    </div>
@endsection
