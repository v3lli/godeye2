<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Journal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journal = Journal::all();
        return Inertia::render('Journals', [
            'journals' => $journal,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('JournalIntake');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'cover' => 'required|string',
            'text' => 'required|longtext'
        ]);

        $journal = Journal::create($request->all());

        return response()->json([
            'message' => 'Journal entry created successfully',
            'entry' => $journal
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $journal = Journal::find($id);
        if (!$journal) {
            return response()->json(['message' => 'Entry not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();

        return response()->json([
            'message' => 'Journal Entry deleted successfully'
        ]);
    }
}
