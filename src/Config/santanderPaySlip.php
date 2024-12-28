<?php

return [
  'SANTANDER_WORKSPACE'     => env('SANTANDER_WORKSPACE', 'your_workspace_default'),
  'SANTANDER_CLIENT_ID'     => env('SANTANDER_CLIENT_ID', 'your_client_id'),
  'SANTANDER_CLIENT_SECRET' => env('SANTANDER_CLIENT_SECRET', 'your_client_secret'),
  'SANTANDER_GRANT_TYPE'    => env('SANTANDER_GRANT_TYPE', 'client_credentials'),
  'SANTANDER_CERT'          => env('SANTANDER_CERT', 'your_cert.pem'),
  'SANTANDER_CERT_KEY'      => env('SANTANDER_CERT_KEY', 'your_ssl_key.pem'),
];