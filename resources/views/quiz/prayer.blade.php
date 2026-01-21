@extends('layouts.app')

@section('title', 'Prayer Points')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="card">
        <div  class="card-header" style="text-align: center;text-decoration: underline;" >
                <h1 sstyle="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;text-align: center;text-decoration: underline;">{{ $quiz->title }}</h1>
    
        </div>
        <!--<p class="text-secondary" style="margin-bottom: 2rem;">{{ $quiz->description }}</p>-->
              <div style="text-align:center;">
  <img src="/hand.png" alt="Hand" style="width:150px; margin-top:20px;">
</div>
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;text-align: center;">Prayer points</h2>

        <div style="background: var(--bg-primary); padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
            <div style="margin-bottom: 0.75rem;">
                <strong style="font-size:14px;">  {!! nl2br(e($quiz->prayerpoints)) !!}</strong> </div>
        </div>

        <!--<div style="background: rgba(79, 70, 229, 0.1); padding: 1rem; border-radius: 10px; border-left: 4px solid var(--primary); margin-bottom: 1.5rem;">-->
               <!--<strong>{!! nl2br(e($quiz->prayerpoints)) !!}</strong>-->
            <!--<p style="margin: 0; font-size: 0.9rem;">-->
               
                
            <!--      {!! nl2br(e($quiz->prayerpoints)) !!}-->
            <!--</p>-->
        <!--</div>-->

    

        <a href="{{ route('dashboard') }}" class="btn btn-success mt-1" style="text-decoration: none;">Back to Home</a>
    </div>
</div>
@endsection
