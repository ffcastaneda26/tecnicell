<?php

namespace App\Observers;

use App\Models\Cotization;
use Illuminate\Support\Facades\Auth;

class CotizationObserver
{
    public function creating(Cotization $cotization)
    {
        $cotization->user_id = Auth::user()->id;
        $cotization->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Cotization $cotization)
    {
        $cotization->user_id = Auth::user()->id;
    }
}
