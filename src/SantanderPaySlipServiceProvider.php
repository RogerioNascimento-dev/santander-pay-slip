<?php

namespace SantanderPaySlip;

use Illuminate\Support\ServiceProvider;
use SantanderPaySlip\Console\InstallSantanderPaySlipCommand;
use SantanderPaySlip\Core\SantanderGateway;
use SantanderPaySlip\Core\SantanderGatewayConfig;

class SantanderPaySlipServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
      $this->app->singleton(SantanderGatewayConfig::class, function ($app) {
        return new SantanderGatewayConfig(
          env('SANTANDER_CLIENT_ID'),
          env('SANTANDER_CLIENT_SECRET'),
          env('SANTANDER_GRANT_TYPE'),
          env('SANTANDER_CERT'),
          env('SANTANDER_CERT_KEY'),
          env('SANTANDER_WORKSPACE'),      
          true
        );
      });
      $this->app->singleton(SantanderGateway::class, function ($app) {
        return new SantanderGateway($app->make(SantanderGatewayConfig::class));
      });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Publicar o arquivo de configuração
        $this->publishes([
            __DIR__ . '/Config/santanderPaySlip.php' => config_path('santanderPaySlip.php'),
        ]);

        // Registrar comandos
        if ($this->app->runningInConsole()) {
            $this->commands([InstallSantanderPaySlipCommand::class]);
        }
    }
}
