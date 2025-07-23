<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    // Affiche la liste des questions.
    public function index(): View
    {
        $questions = Question::paginate(10);
        return view('questions.index', compact('questions'));
    }

    // Affiche le formulaire pour créer une nouvelle question.
    public function create(): View
    {
        return view('questions.create');
    }

    // Enregistre une nouvelle question en base de données.
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'reponse' => 'required|string',
        ]);

        Question::create($validated);

        return redirect()->route('questions.index')
            ->with('success', 'Question créée avec succès.');
    }

    // Affiche les détails d'une question spécifique.
    public function show(Question $question): View
    {
        return view('questions.show', compact('question'));
    }

    // Affiche le formulaire pour éditer une question spécifique.
    public function edit(Question $question): View
    {
        return view('questions.edit', compact('question'));
    }

    // Met à jour une question spécifique en base de données.
    public function update(Request $request, Question $question): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'reponse' => 'required|string',
        ]);

        $question->update($validated);

        return redirect()->route('questions.index')
            ->with('success', 'Question mise à jour avec succès.');
    }

    // Supprime une question spécifique de la base de données.
    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Question supprimée avec succès.');
    }
}
