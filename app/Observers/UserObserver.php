<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (!auth()->check()){
            return;
         }

        if($user->id == 1){
            if(!$user->hasRole('Admin')){
                $user->assignRole('Admin');
            }
            return;
        }



        $exists_role_suscriptor=Role::where('name',env('APP_ROL_TO_SUSCRIPTOR','Suscriptor'))->exists();
        if(!$exists_role_suscriptor){
            return;
        }
        // Si usuario tiene el rol
        if( Auth::user()->roles->count()
         && Auth::user()->hasRole(env('APP_ROL_TO_SUSCRIPTOR','Gerente'))
         && Auth::user()->companies->count() ){
                $user->companies()->sync(Auth::user()->companies->first());
        }
    }



    /**
     * Handle the User "updated" event.
     */
    // public function updated(User $user): void
    // {
    //     if(Auth::user()->companies->count()){
    //         $user->companies()->sync(Auth::user()->companies->first);
    //      }
    // }


}
