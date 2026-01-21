<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class QuizController extends Controller
{
    public function instructions($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        return view('quiz.instructions', compact('quiz'));
    }
    
     public function prayer($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        return view('quiz.prayer', compact('quiz'));
    }

    public function start($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        // Create new attempt
        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'total_questions' => $quiz->questions->count(),
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('quiz.question', ['attemptId' => $attempt->id, 'questionNumber' => 1]);
    }

    public function question($attemptId, $questionNumber)
    {
        $attempt = QuizAttempt::with(['quiz.questions.options', 'userAnswers'])
            ->where('user_id', auth()->id())
            ->findOrFail($attemptId);

        if ($attempt->status === 'completed') {
            return redirect()->route('quiz.result', $attempt->id);
        }

        $questions = $attempt->quiz->questions;
        $currentQuestion = $questions[$questionNumber - 1] ?? null;

        if (!$currentQuestion) {
            return redirect()->route('quiz.result', $attempt->id);
        }

        // Get user's answer for this question if exists
        $userAnswer = $attempt->userAnswers()
            ->where('question_id', $currentQuestion->id)
            ->first();

        return view('quiz.question', compact('attempt', 'currentQuestion', 'questionNumber', 'questions', 'userAnswer'));
    }

    public function saveAnswer(Request $request, $attemptId)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'required|exists:options,id',
        ]);

        $attempt = QuizAttempt::where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->findOrFail($attemptId);

        // Check if option is correct
        $option = \App\Models\Option::findOrFail($request->option_id);

        // Update or create user answer
        UserAnswer::updateOrCreate(
            [
                'attempt_id' => $attempt->id,
                'question_id' => $request->question_id,
            ],
            [
                'option_id' => $request->option_id,
                'is_correct' => $option->is_correct,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function submit($attemptId)
    {
         $now = Carbon::now();
        $attempt = QuizAttempt::with(['quiz', 'userAnswers'])
            ->where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->findOrFail($attemptId);

        // Calculate score
        $correctAnswers = $attempt->userAnswers()->where('is_correct', true)->count();
        $timeTaken  = $attempt->started_at->diffInSeconds(now());

        $attempt->update([
            'score' => $correctAnswers,
            'time_taken' => $timeTaken,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('quiz.result', $attempt->id);
    }

    public function result($attemptId)
    {
        $attempt = QuizAttempt::with('quiz')
            ->where('user_id', auth()->id())
            ->findOrFail($attemptId);

        $percentage = ($attempt->score / $attempt->total_questions) * 100;
        $passed = $percentage >= $attempt->quiz->passing_score;

        return view('quiz.result', compact('attempt', 'percentage', 'passed'));
    }

    public function review($attemptId)
    {
        $attempt = QuizAttempt::with([
            'quiz.questions.options',
            'userAnswers.question.options',
            'userAnswers.option'
        ])
            ->where('user_id', auth()->id())
            ->findOrFail($attemptId);

        return view('quiz.review', compact('attempt'));
    }
}
