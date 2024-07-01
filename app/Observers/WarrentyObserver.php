<?php

namespace App\Observers;

use App\Models\Warranty;
use Illuminate\Support\Facades\Auth;

class WarrentyObserver
{
    public function creating(Warranty $record)
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }

    public function editing(Warranty $record)
    {
        $record->user_id = Auth::user()->id;
    }
}
