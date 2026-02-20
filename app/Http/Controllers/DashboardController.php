<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;

use App\Models\Prayer;
use App\Models\Verse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    
    public function index()
    {
        // Fetch Top 10 Users by Total Score
        $topUsers = \App\Models\QuizAttempt::with('user')
            ->select('user_id', \Illuminate\Support\Facades\DB::raw('SUM(score) as total_score'))
            ->groupBy('user_id')
            ->orderByDesc('total_score')
            ->limit(10)
            ->get();
            
          $Todayquizzes = Quiz::whereDoesntHave('attempts', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->withCount('questions')
                ->orderByRaw('DATE(date) = CURDATE() DESC')
                ->get();

          $quizzes = Quiz::whereDoesntHave('attempts', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->withCount('questions')
                ->orderByRaw('DATE(date) < CURDATE() DESC')
                ->orderBy('date', 'Desc')
                ->paginate(15);


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

        return view('dashboard', compact('quizzes', 'recentAttempts', 'stats','topUsers', 'Todayquizzes'));
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

 public function memoryverse_page()
    {
        $verse = verse::all();

        return view('verse.index', compact('verse'));
    }

     public function verse($id)
    {
        $data = verse::findOrFail($id);
        
        return view('verse.show', compact('data'));
    }
}
