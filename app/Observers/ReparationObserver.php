<?php

namespace App\Observers;

use App\Models\Reparation;
use Illuminate\Support\Facades\Auth;

class ReparationObserver
{
    public function creating(Reparation $record)
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Reparation $record)
    {
        $record->user_id = Auth::user()->id;
    }
}
