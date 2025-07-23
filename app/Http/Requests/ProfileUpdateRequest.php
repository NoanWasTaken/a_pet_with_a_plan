<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    // Récupère les règles de validation qui s'appliquent à la requête.
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('utilisateur', 'email')->ignore($this->user()->id),
            ],
            'devise_preferee' => ['required', 'in:EUR,USD,GBP,CAD'],
        ];
    }
}
