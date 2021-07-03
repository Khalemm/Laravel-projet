<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-admin', function (User $user) { //determine l'autorisation de l'utilisateur admin
            return $user->admin;
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Bienvenue chez Laravel-site')
                ->greeting('Bonjour,')
                ->line('Veuillez cliquer le bouton ci-dessous pour vérifier votre adresse mail.')
                ->action('Vérification', $url)
                ->line('Votre compte sera activé d`ici quelques jours.')
                ->line('Merci !');
        });
    }
}
