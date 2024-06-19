<?php

namespace App\Observers;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchObserver
{
    public function creating(Branch $branch)
    {
        $branch->user_id = Auth::user()->id;
        $branch->company_id = Auth::user()->companies->first()->id;
    }
    /**
     * Handle the Branch "created" event.
     */
    public function created(Branch $branch): void
    {
        $branch->user_id = Auth::user()->id;
        $branch->company_id = Auth::user()->companies->first()->id;
    }

    public function updating(Branch $branch)
    {
        $branch->user_id = Auth::user()->id;
        $branch->company_id = Auth::user()->companies->first()->id;
    }
    /**
     * Handle the Branch "updated" event.
     */
    public function updated(Branch $branch): void
    {
        $branch->user_id = Auth::user()->id;
        $branch->company_id = Auth::user()->companies->first()->id;
    }


}
