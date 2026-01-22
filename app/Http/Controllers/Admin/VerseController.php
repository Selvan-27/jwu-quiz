<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Verse;
use Illuminate\Http\Request;

class VerseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Verse::latest()->get();
        return view('admin.verse.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.verse.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Verse::create($validated);

        return redirect()
            ->route('admin.verse.index')
            ->with('success', 'Memory Verse created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Verse $verse)
    {
        return view('admin.verse.show', [
            'data' => $verse
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Verse $verse)
    {
        return view('admin.verse.edit', [
            'data' => $verse
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Verse $verse)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $verse->update([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'is_active'   => $request->has('is_active'),
        ]);

        return back()->with('success', 'Memory Verse updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Verse $verse)
    {
        $verse->delete();

        return redirect()
            ->route('admin.verse.index')
            ->with('success', 'Memory Verse Deleted successfully.');
    }
}
