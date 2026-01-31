@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container content-with-nav">
    <div style="padding:0 0; display:flex; align-items:center;">
    <div style="width:50%;">
        <h1 style="font-size:1.5rem; font-weight:700;">
            Hi, {{ auth()->user()->name }}! 👋
        </h1>
        <p class="text-secondary">Bible Knowledge Quiz?</p>
    </div>

    <div style="width:50%; text-align:right;">
        <img src="/jwu.png" style="width:180px; border-radius:25px;">
    </div>
</div>


    @if($stats['total_attempts'] > 0)
    <div class="card" style="background: #7604c2;background: linear-gradient(135deg,rgba(118, 4, 194, 1) 0%, rgba(252, 176, 69, 1) 83%);color:white;">
        <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Your Stats</h3>
        <div class="flex justify-between">
            <div>
                <div style="font-size: 2rem; font-weight: 700;">{{ $stats['total_attempts'] }}</div>
                <div style="opacity: 0.9;">Quizzes Taken</div>
            </div>
            <div>
                <a href="{{ route('history.index') }}" style="color: white;font-weight: bolder;text-decoration: none;" >
                <div style="font-size: 2rem; font-weight: 700;">📊</div>
                <div style="opacity: 0.9;">Results</div> </a>
             </div>
        </div>
    </div>
    @endif

    <h2 style="font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 1rem;">Available Quizzes</h2>

    @forelse($quizzes as $quiz)
    @if($quiz->questions_count)
        
    <div class="card">
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $quiz->title }}</h3>  <h5 style="font-size: 1.1rem; font-weight: 500; margin-bottom: 0.5rem;float: right;">{{ \Carbon\Carbon::parse($quiz->date)->format('d-m-Y') }}</h5>
        <p class="text-secondary" style="margin-bottom: 1rem; font-size: 0.9rem;">{{ Str::limit($quiz->description, 80) }}</p>
        
        <div class="flex justify-between items-center" style="margin-bottom: 1rem;">
            <div style="display: flex; gap: 1rem; font-size: 0.85rem;">
                <span>📝 {{ $quiz->questions_count }} Questions</span>
                <span>⏱️ {{ $quiz->time_limit }} min</span>
            </div>
        </div>


   <div class="row">
            
        <a href="{{ route('quiz.instructions', $quiz->id) }}" class="btn btn-primary" style="text-decoration: none;">Start Quiz</a>
    
        <!--@if(isset($quiz->prayerpoints))-->
        <!--<a href="{{ route('quiz.prayer', $quiz->id) }}" class="btn btn-primary col-6" style="text-decoration: none;display: inline;width:50%">Prayer Points</a>-->
        <!--@endif-->
        </div>
        
        
        <!--<div class="row">-->
        <!--@if($quiz->questions_count!=0)-->
            
        <!--<a href="{{ route('quiz.instructions', $quiz->id) }}" class="btn btn-primary col-6" style="text-decoration: none;display: inline;">Start Quiz</a>-->
        <!--@endif-->
        <!--@if(isset($quiz->prayerpoints))-->
        <!--<a href="{{ route('quiz.prayer', $quiz->id) }}" class="btn btn-primary col-6" style="text-decoration: none;display: inline;width:50%">Prayer Points</a>-->
        <!--@endif-->
        <!--</div>-->
        
    </div>
        @endif
    @empty
    <div class="card text-center">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
        <p class="text-secondary">No quizzes available at the moment.</p>
    </div>
    @endforelse
</div>

<!-- pagination -->
 <div style="margin-top: 1.5rem;margin-bottom: 10rem;">
          {{ $quizzes->links('pagination::bootstrap-5') }}
        </div>
        
<!-- Bottom Navigation -->

 @include('layouts.bottom-nav')
 
@endsection
