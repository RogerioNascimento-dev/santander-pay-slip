<?php

namespace SantanderPaySlip\Console;
use Illuminate\Console\Command;

class InstallSantanderPaySlipCommand extends Command
{
    protected $signature = 'santanderpayslip:install';
    protected $description = 'Instala a biblioteca e configura o .env';

    public function handle()
    {
        // Adicionar variáveis ao arquivo .env
        $this->info('Adicionando variáveis ao .env...');
        $this->updateEnv([
            'SANTANDER_WORKSPACE'     => 'your_workspace_default',
            'SANTANDER_CLIENT_ID'     => 'your_client_id',
            'SANTANDER_CLIENT_SECRET' => 'your_client_secret',
            'SANTANDER_GRANT_TYPE'    => 'client_credentials',
            'SANTANDER_CERT'          => 'your_cert.pem',
            'SANTANDER_CERT_KEY'      => 'your_ssl_key.pem',
        ]);
        $this->info('Biblioteca instalada com sucesso!');
    }

    private function updateEnv(array $data)
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            $this->error('Arquivo .env não encontrado!');
            return;
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            if (strpos($envContent, "$key=") === false) {                
                file_put_contents($envPath, PHP_EOL . "$key=$value", FILE_APPEND);
            }
        }
    }
}
