<?php

namespace App\Observers;

use App\Models\Reparation;
use Illuminate\Support\Facades\Auth;

class ReparationObserver
{
    public function creating(Reparation $reparation)
    {
        $reparation->user_id = Auth::user()->id;
        $reparation->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Reparation $reparation)
    {
        $reparation->user_id = Auth::user()->id;
    }
}
