<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if($user->id == 1){
            if(!$user->hasRole('Admin')){
                $user->assignRole('Admin');
            }
        }else{
            if(Auth::user()->companies->count()){
                $user->companies()->sync(Auth::user()->companies->first());
             }
        }

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        dd(Auth::user()->companies->count());

        if(Auth::user()->companies->count()){
            $user->companies()->sync(Auth::user()->companies->first);
         }
    }

    // public function updating(User $user): void
    // {
    //     dd('Se está actualizando');

    // }

}
