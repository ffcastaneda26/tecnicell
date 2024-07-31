<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', function () {
    if (auth()->check()) {
        if(Auth::user()->hasRole('Admin')){
            return redirect()->route('/admin');
        }
        $exists_role_suscriptor=Role::where('name',env('APP_ROL_TO_SUSCRIPTOR','Suscriptor'))->exists();

        if($exists_role_suscriptor){
            if(Auth::user()->hasRole(env('APP_ROL_TO_SUSCRIPTOR','Suscriptor')) && !Auth::user()->companies->count() ){
                return redirect()->to('/company/companies/create');
            }
            return redirect()->route('dashboard');
        }
    } else {
        return view('welcome');
    }
})->name('home');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        if(Auth::user()->hasRole('Admin')){
            return redirect()->to('/admin');
        }
        $exists_role_suscriptor=Role::where('name',env('APP_ROL_TO_SUSCRIPTOR','Gerente'))->exists();

        if($exists_role_suscriptor){
            if(Auth::user()->hasRole(env('APP_ROL_TO_SUSCRIPTOR','Gerente')) ){
                if(!Auth::user()->companies->count()){
                    return redirect()->to('/company/companies/create');
                }else{
                    return redirect()->to('/company');
                }
            }
        }
        return view('dashboard');
    })->name('dashboard');
});
