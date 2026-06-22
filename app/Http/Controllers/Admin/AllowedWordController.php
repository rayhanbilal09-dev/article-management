<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllowedWord;
use Illuminate\Http\Request;

class AllowedWordController extends Controller
{
    /**
     * Display a listing of the allowed words.
     */
    public function index()
    {
        $allowedWords = AllowedWord::orderBy('word', 'asc')->paginate(20);
        return view('admin.allowed_words.index', compact('allowedWords'));
    }

    /**
     * Store a newly created allowed word in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'word' => 'required|string|max:100|unique:allowed_words,word',
        ]);

        // Convert to lowercase to ensure consistency
        AllowedWord::create([
            'word' => strtolower($validated['word']),
        ]);

        return redirect()->route('allowed-words.index')->with('success', 'Kata/kalimat berhasil ditambahkan ke whitelist!');
    }

    /**
     * Remove the specified allowed word from storage.
     */
    public function destroy(AllowedWord $allowedWord)
    {
        $allowedWord->delete();

        return redirect()->route('allowed-words.index')->with('success', 'Kata/kalimat berhasil dihapus dari whitelist!');
    }
}
