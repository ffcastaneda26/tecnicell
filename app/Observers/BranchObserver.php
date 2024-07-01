<?php

namespace App\Observers;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchObserver
{
    public function creating(Branch $record)
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }
    /**
     * Handle the Branch "created" event.
     */
    public function created(Branch $record): void
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }

    public function updating(Branch $record)
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }
    /**
     * Handle the Branch "updated" event.
     */
    public function updated(Branch $record): void
    {
        $record->user_id = Auth::user()->id;
        $record->company_id = Auth::user()->companies->first()->id;
    }


}
