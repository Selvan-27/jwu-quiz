<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;

use App\Models\Prayer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    
    public function index()
    {
    //return "here";
        // $quizzes = Quiz::where('is_active', true)
        //     ->withCount('questions')
        //     ->get();
        
           $quizzes = Quiz::where('is_active', true)
    ->whereDoesntHave('attempts', function ($query) {
        $query->where('user_id', auth()->id());
    })
    ->withCount('questions')
    ->get();


        $recentAttempts = QuizAttempt::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->with('quiz')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_attempts' => QuizAttempt::where('user_id', auth()->id())
                ->where('status', 'completed')
                ->count(),
            'average_score' => QuizAttempt::where('user_id', auth()->id())
                ->where('status', 'completed')
                ->avg('score'),
        ];

        return view('dashboard', compact('quizzes', 'recentAttempts', 'stats'));
    }
    
        
    public function prayer_page()
    {
        $data = Prayer::wherenotnull('prayerpoints')->get();

        return view('prayer.index', compact('data'));
    }
    
       public function prayer_points($id)
    {
        $data = Prayer::findOrFail($id);
        
        return view('prayer.show', compact('data'));
    }
}
