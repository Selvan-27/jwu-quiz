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
                <div style="font-size: 2rem; font-weight: 700;text-align: center;"> <i class="fa fa-trophy" aria-hidden="true"></i></div>
                <div style="opacity: 0.9;">View Results</div> </a>
             </div>
        </div>
    </div>
    @endif


        <!-- Stories Style Leaderboard -->
    @if(isset($topUsers) && $topUsers->count() > 0)
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <h2 style="font-size: 1rem; font-weight: 700; color: #4F46E5;">Top Rankers</h2>
            <!-- <a href="{{ route('rank') }}" style="font-size: 0.8rem; text-decoration: none;">View All</a> -->
        </div>
        
        <div class="stories-container" style="display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 1rem; scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($topUsers as $index => $ranking)
            @php $rank = $index + 1; @endphp
            <div style="display: flex; flex-direction: column; align-items: center; min-width: 70px;">
                <div class="story-circle rank-{{ $rank }}" 
                     style="width: 65px; height: 65px; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: relative;
                            background: {{ $rank == 1 ? 'linear-gradient(45deg, #FFD700, #FDB931)' : ($rank == 2 ? 'linear-gradient(45deg, #E0E0E0, #BDBDBD)' : ($rank == 3 ? 'linear-gradient(45deg, #CD7F32, #A0522D)' : '#f3f4f6')) }};
                            padding: 3px;">
                    <div style="width: 100%; height: 100%; background: white; border-radius: 50%; padding: 2px; overflow: hidden; position: relative;">
                         <!-- Rank Number Overlay -->
                         <div style="position: absolute; inset: 0; display: flex; justify-content: center; align-items: center; background: linear-gradient(135deg,rgba(118, 4, 194, 1) 0%, rgba(252, 176, 69, 1) 83%); color: white; font-weight: 700; font-size: 1.2rem;">
                            #{{ $rank }}
                         </div>
                         <!-- Fallback Avatar (since we don't have real images yet) -->
                         <div style="width: 100%; height: 100%; background: #e5e7eb; display: none;"></div> 
                    </div>
                </div>
                <div style="text-transform: uppercase;font-size: 0.75rem; font-weight: 600; margin-top: 0.25rem; text-align: center; max-width: 70px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ explode(' ', $ranking->user->name)[0] }}
                </div>
                <div style="font-size: 0.65rem; color: #6b7280;">{{ $ranking->total_score }} pts</div>
            </div>
            @endforeach
        </div>
        <style>
            .stories-container::-webkit-scrollbar { display: none; }
            .story-circle.rank-1 { box-shadow: 0 0 10px rgba(255, 215, 0, 0.5); transform: scale(1.05); }
        </style>
    </div>
    @endif


<h2 style="font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 1rem;">
    Available Quizzes
</h2>

@foreach($Todayquizzes as $quiz)
    @php
        $quizDate = \Carbon\Carbon::parse($quiz->date);
        $now = \Carbon\Carbon::now();

        $isToday = $quizDate->isToday();
        $after930 = $now->format('H:i') >= '21:30';
    @endphp

@if($isToday && $after930)

        <div class="card today-quiz">
    <!-- <div class="card {{ $isToday ? 'today-quiz' : '' }}"> -->
        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">
            {{ $quiz->title }}
        </h3>

        <h5 style="font-size: 1.1rem; font-weight: 500; margin-bottom: 0.5rem; float: right;">
            {{ \Carbon\Carbon::parse($quiz->date)->format('d-m-Y') }}
        </h5>

        <p class="text-secondary" style="margin-bottom: 1rem; font-size: 0.9rem;">
            {{ Str::limit($quiz->description, 80) }}
        </p>

        <div class="flex justify-between items-center" style="margin-bottom: 1rem;">
            <div style="display: flex; gap: 1rem; font-size: 0.85rem;">
                <span>📝 {{ $quiz->questions_count }} Questions</span>
                <span>⏱️ {{ $quiz->time_limit }} min</span>
            </div>
        </div>

        <div class="row">
            <a href="{{ route('quiz.instructions', $quiz->id) }}"
               class="btn btn-primary"
               style="text-decoration: none;">
                Start Quiz
            </a>
        </div>
    </div>
@endif

@endforeach


        <div class="card">

        <ul>

      @forelse($quizzes as $quiz)
<li style="
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1px solid #eee;
    font-size:0.9rem;
">
    
    <!-- LEFT SIDE : Quiz info -->
    <div>
        <div style="font-weight:600;">📝 {{ $quiz->title }}</div>
        <div style="color:#6b7280; font-size:0.8rem;">📅 {{ \Carbon\Carbon::parse($quiz->date)->format('d-m-Y') }}</div>
    </div>

    <!-- RIGHT SIDE : Button -->
    <a href="{{ route('quiz.instructions', $quiz->id) }}"
       class="btn btn-primary btn-sm"
       style="padding:6px 16px; font-size:0.85rem;width: 110px; text-decoration: none;">
        Start Quiz
    </a>

</li>
@empty
<p>No quizzes available</p>
@endforelse


        </ul>


      




<!-- pagination -->
 <div style="margin-top: 1.5rem;margin-bottom: 10rem;">
          {{ $quizzes->links('pagination::bootstrap-5') }}
        </div>
        
<!-- Bottom Navigation -->

 @include('layouts.bottom-nav')
 
@endsection
