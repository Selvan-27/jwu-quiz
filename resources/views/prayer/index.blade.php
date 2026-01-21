@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container content-with-nav">
<!--    <div style="padding:1.5rem 0; display:flex; align-items:center;">-->
<!--    <div style="width:70%;">-->
<!--        <h1 style="font-size:1.5rem; font-weight:700;">-->
<!--            Hi, {{ auth()->user()->name }}! 👋-->
<!--        </h1>-->
<!--        <p class="text-secondary">Bible Knowledge Quiz?</p>-->
<!--    </div>-->

<!--    <div style="width:30%; text-align:right;">-->
<!--        <img src="/jwu.png" style="width:180px; border-radius:25px;">-->
<!--    </div>-->
<!--</div>-->



    <div class="card" style="background: #7604c2;background: linear-gradient(135deg,rgba(118, 4, 194, 1) 0%, rgba(252, 176, 69, 1) 83%);color:white;">
        <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Prayer Points</h3>
        <!--<div class="flex justify-between">-->
        <!--    <div>-->
        <!--        <div style="font-size: 2rem; font-weight: 700;"></div>-->
        <!--        <div style="opacity: 0.9;">Quizzes Taken</div>-->
        <!--    </div>-->
        <!--    <div>-->
        <!--        <div style="font-size: 2rem; font-weight: 700;"></div>-->
        <!--        <div style="opacity: 0.9;">Avg Score</div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>


    <!--<h2 style="font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 1rem;">Prayer Points</h2>-->

    @forelse($data as $data)
    <div class="card">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $data->title }}</h3>  <h5 style="font-size: 1.1rem; font-weight: 500; margin-bottom: 0.5rem;float: right;">{{ $data->created_at->format('d-M') }}</h5>
        <p class="text-secondary" style="margin-bottom: 1rem; font-size: 0.9rem;">{{ Str::limit($data->prayerpoints, 60) }}</p>
        
        <!--<div class="flex justify-between items-center" style="margin-bottom: 1rem;">-->
        <!--    <div style="display: flex; gap: 1rem; font-size: 0.85rem;">-->
        <!--        <span>📝 {{ $data->questions_count }} Questions</span>-->
        <!--        <span>⏱️ {{ $data->time_limit }} min</span>-->
        <!--    </div>-->
        <!--</div>-->

        <div class="row">

        @if(isset($data->prayerpoints))
        <a href="{{ route('prayer.show', $data->id) }}" class="btn btn-secondary" style="text-decoration: none;">Prayer Points</a>
        @endif
        </div>
        
    </div>
    @empty
    <div class="card text-center">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
        <p class="text-secondary">No prayerpoints available at the moment.</p>
    </div>
    @endforelse
</div>

<!-- Bottom Navigation -->

 @include('layouts.bottom-nav')
 

@endsection
