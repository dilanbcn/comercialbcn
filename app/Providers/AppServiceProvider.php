<?php

namespace App\Providers;

use App\Mail\NuevaReunionMail;
use App\Models\ClienteComunicacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ClienteComunicacion::created(function ($comunicacion) {
            if ($comunicacion->fecha_reunion != null) {
                retry(5, function () use ($comunicacion) {
                    $prospector = User::find($comunicacion->prospector_id);
                    Mail::to($prospector->email)->send(new NuevaReunionMail($comunicacion));
                }, 100);
            }
        });
    }
}
