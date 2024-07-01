<?php

namespace App\Observers;

use App\Models\Cotization;
use Illuminate\Support\Facades\Auth;

class CotizationObserver
{
    public function creating(Cotization $record)
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Cotization $record)
    {
        $record->user_id = Auth::user()->id;
    }
}
