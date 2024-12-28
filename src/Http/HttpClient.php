<?php
namespace SantanderPaySlip\Http;

use Exception;
use SantanderPaySlip\Exceptions\ApiException;
use GuzzleHttp\Client;
use SantanderPaySlip\Core\SantanderGatewayConfig;
use Illuminate\Support\Facades\Cache;

class HttpClient
{
    private Client $httpClient;    
    private SantanderGatewayConfig $config;

    public function __construct(SantanderGatewayConfig $config)
    {
        $this->config     = $config;
        $this->httpClient = new Client($this->config->getClientConfig());
    }

    public function get(string $endpoint, array $queryParams = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $queryParams]);
    }
    
    public function post(string $endpoint, array $bodyParams = []): array
    {
        $payload = !empty($bodyParams) ? json_encode($bodyParams) : null;
        return $this->request('POST', $endpoint, ['body' => $payload]);
    }

    private function request(string $method, string $endpoint, array $options = []): array
    {   
      $maxRetries = 3;
      $attempts   = 0;
      while ($attempts <= $maxRetries) {
        try {
          $options = array_merge([
            'headers' => [
              'Content-Type'      => 'application/json',
              'X-Application-Key' => $this->config->getClientId(),
              'Authorization'     => $this->getToken(),
            ]
          ], $options);
          $response = $this->httpClient->request($method, $endpoint, $options);
          return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            $attempts++;
            $this->tokenRefreshStrategy($e, $attempts, $maxRetries);
            continue;
        }
      }
      // If all attempts fail, it throws an exception
      throw new ApiException("API request failed after the {$maxRetries} retries.", 401); 
    }   

    public function getToken(bool $refresh = false) :string 
    {
      if($refresh)      
        Cache::forget('SANTANDER_BEARER_TOKEN');

      if(!Cache::has('SANTANDER_BEARER_TOKEN'))
      {
        $options = [
          'headers' => [
          'Content-Type' => 'application/x-www-form-urlencoded'
          ],
          'form_params' => [
            'grant_type'    => $this->config->getGrantType(),
            'client_id'     => $this->config->getClientId(),
            'client_secret' => $this->config->getClientSecret()
          ]
        ];

        $response  = $this->httpClient->request('POST', $this->config->getTokenUrl(), $options);      
       
        if(!$response->getStatusCode() == 200){
          throw new ApiException("Auth API request failed ", $response->getStatusCode());
        }

        $response = json_decode($response->getBody()->getContents(), true);  
        Cache::put('SANTANDER_BEARER_TOKEN', "Bearer ".$response['access_token'], $response['expires_in']);
      }
      return Cache::get('SANTANDER_BEARER_TOKEN');
    }   

    private function tokenRefreshStrategy(Exception $e, int $attempts,int $maxRetries): void
    {
      if($e->getCode() !== 401)
        throw new ApiException("API request failed: " . $e->getMessage(), $e->getCode(), $e);

      if ($e->getCode() === 401 && $attempts <= $maxRetries) {              
        $this->getToken(true);
        return;
      }      
    }
}