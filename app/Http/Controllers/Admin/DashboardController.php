<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => \App\Models\User::where('is_admin',0)->count(),
            'total_quizzes' => \App\Models\Quiz::count(),
            'active_quizzes' => \App\Models\Quiz::where('is_active', true)->count(),
            'total_attempts' => \App\Models\QuizAttempt::count(),
            'today_attempts' => \App\Models\QuizAttempt::whereDate('created_at', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
