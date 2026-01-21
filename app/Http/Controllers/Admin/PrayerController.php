<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prayer;
use Illuminate\Http\Request;

class PrayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Prayer::latest()->get();

        return view('admin.prayerpoints.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prayerpoints.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'prayerpoints'  => 'required|string',
        ]);

        Prayer::create($validated);

        return redirect()
            ->route('admin.prayer.index')
            ->with('success', 'Prayer points created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prayer $prayer)
    {
        return view('admin.prayerpoints.show', [
            'data' => $prayer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prayer $prayer)
    {
        return view('admin.prayerpoints.edit', [
            'data' => $prayer
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Prayer $prayer)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'prayerpoints'  => 'required|string',
        ]);

        $prayer->update([
            'title'        => $validated['title'],
            'prayerpoints' => $validated['prayerpoints'],
            'is_active'    => $request->has('is_active'),
        ]);

        return back()->with('success', 'Prayer points updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Prayer $prayer)
    {
        $prayer->delete();

        return redirect()
            ->route('admin.prayer.index')
            ->with('success', 'Prayer points deleted successfully.');
    }
}
