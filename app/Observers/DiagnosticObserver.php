<?php

namespace App\Observers;

use App\Models\Diagnostic;
use Illuminate\Support\Facades\Auth;

class DiagnosticObserver
{
    public function creating(Diagnostic $record)
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Diagnostic $record)
    {
        $record->user_id = Auth::user()->id;

    }
}
