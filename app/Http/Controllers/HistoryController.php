<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $attempts = QuizAttempt::with('quiz')
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->paginate(15);

        return view('history.index', compact('attempts'));
    }

    public function show($attemptId)
    {
        $attempt = QuizAttempt::with('quiz')
            ->where('user_id', auth()->id())
            ->findOrFail($attemptId);

        $percentage = ($attempt->score / $attempt->total_questions) * 100;
        $passed = $percentage >= $attempt->quiz->passing_score;

        return view('quiz.result', compact('attempt', 'percentage', 'passed'));
    }
}
