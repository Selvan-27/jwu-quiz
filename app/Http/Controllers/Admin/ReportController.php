<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
         $quizzes = \App\Models\Quiz::withCount('attempts')->withCount('questions')->get();

          $total_users = \App\Models\User::where('is_admin',0)->count();
        
        $reportData = $quizzes->where('questions_count','!=',0)->map(function($quiz) {
            $attempts = $quiz->attempts;
            $totalAttempts = $attempts->count();
            
            if ($totalAttempts > 0) {
                $avgScore = $attempts->avg('score');
                // Calculate percentage based on total questions (assuming standard scoring)
                // This is an estimation. For strict accuracy we'd need max score per attempt.
                // But for now, let's use the score directly if it represents correct answers count
                
                     $percentage = 0;
                    $percentage = ($total_users / $totalAttempts) * 100;
                
                $passRate = ($passCount / $totalAttempts) * 100;
            } else {
                $avgScore = 0;
                $passRate = 0;
            }

            return [
                'title' => $quiz->title,
                'total_attempts' => $totalAttempts,
                'avg_score' => round($percentage, 1),
                'pass_rate' => round($passRate, 1)
            ];
        });

        return view('admin.reports.index', compact('reportData'));
    }
    
      public function show(\App\Models\Quiz $quiz)
    {
        $attempts = $quiz->attempts()
            ->with(['user'])
            ->latest()
            ->get();

        return view('admin.reports.show', compact('quiz', 'attempts'));
    }
}
