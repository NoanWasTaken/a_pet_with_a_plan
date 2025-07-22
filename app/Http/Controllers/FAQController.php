<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FAQController extends Controller
{
    // Afficher la FAQ
    public function index(Request $request): View
    {
        $query = Question::query();

        // Recherche dans les questions
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('question', 'like', '%' . $request->search . '%')
                  ->orWhere('reponse', 'like', '%' . $request->search . '%');
            });
        }

        $questions = $query->orderBy('question')->get();
        
        return view('public.faq', compact('questions'));
    }
}
