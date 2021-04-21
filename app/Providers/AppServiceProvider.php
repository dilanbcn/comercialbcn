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
                $adminPros = User::where(['rol_id' => 4])->orWhere(['id' => $comunicacion->prospector_id])->get();
                $mails = array();
                if ($adminPros) {
                    foreach ($adminPros as $user){
                        $mails[] = $user->email;
                    }
                }

                if (count($mails) > 0){
                    retry(5, function () use ($comunicacion, $mails) {
                        // Mail::to($mails)->send(new NuevaReunionMail($comunicacion));
                        Mail::to('dgonzalez@bcnschool.cl')->send(new NuevaReunionMail($comunicacion));
                    }, 100);
                }
                
            }
        });
    }
}
