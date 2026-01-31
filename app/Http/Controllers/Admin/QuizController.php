<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = \App\Models\Quiz::withCount('questions')->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // 'description' => 'required|string',
            'date'=>'required',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        \App\Models\Quiz::create($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function show(\App\Models\Quiz $quiz)
    {
        $quiz->load(['questions.options']);
        return view('admin.quizzes.show', compact('quiz'));
    }

    public function edit(\App\Models\Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, \App\Models\Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date'=>'required',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(\App\Models\Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
