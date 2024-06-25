<?php

namespace App\Observers;

use App\Models\Diagnostic;
use Illuminate\Support\Facades\Auth;

class DiagnosticObserver
{
    public function creating(Diagnostic $diagnostic)
    {
        $diagnostic->user_id = Auth::user()->id;
        $diagnostic->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Diagnostic $diagnostic)
    {
        $diagnostic->user_id = Auth::user()->id;

    }
}
