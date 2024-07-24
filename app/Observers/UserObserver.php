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
            return;
        }

        // Si usuario tiene el rol
        if(Auth::user()->hasRole(env('APP_ROL_TO_SUSCRIPTOR','Gerente'))){
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
        if(Auth::user()->companies->count()){
            $user->companies()->sync(Auth::user()->companies->first);
         }
    }


}
