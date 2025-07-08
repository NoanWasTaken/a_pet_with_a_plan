<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    
    //Afficher la vue de la mise en page de l'application.
    public function render(): View
    {
        return view('layouts.guest');
    }
}
