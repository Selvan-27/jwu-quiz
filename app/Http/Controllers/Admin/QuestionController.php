<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create($quizId)
    {
        $quiz = \App\Models\Quiz::findOrFail($quizId);
        return view('admin.questions.create', compact('quiz'));
    }

    public function store(Request $request, $quizId)
    {
        $quiz = \App\Models\Quiz::findOrFail($quizId);
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);

        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
            'explanation' => $validated['explanation'],
            'order' => $quiz->questions()->count() + 1,
        ]);

        foreach ($validated['options'] as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index == $validated['correct_option'],
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.quizzes.show', $quiz->id)->with('success', 'Question added successfully.');
    }

    public function edit($quizId, $questionId)
    {
        $quiz = \App\Models\Quiz::findOrFail($quizId);
        $question = $quiz->questions()->with('options')->findOrFail($questionId);
        return view('admin.questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, $quizId, $questionId)
    {
        $quiz = \App\Models\Quiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($questionId);
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'explanation' => $validated['explanation'],
        ]);

        // Delete old options and recreate new ones (simplifies logic)
        $question->options()->delete();

        foreach ($validated['options'] as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index == $validated['correct_option'],
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.quizzes.show', $quiz->id)->with('success', 'Question updated successfully.');
    }

    public function destroy($quizId, $questionId)
    {
        $quiz = \App\Models\Quiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($questionId);
        $question->delete();
        
        return back()->with('success', 'Question deleted successfully.');
    }
}
