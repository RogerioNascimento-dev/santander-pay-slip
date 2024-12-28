<?php
namespace SantanderPaySlip\Core;

use SantanderPaySlip\Http\HttpClient;

class SantanderGateway
{
  private SantanderGatewayConfig $config;
  private HttpClient $httpClient;

  public function __construct(SantanderGatewayConfig $config)
  {
    $this->config     = $config;
    $this->httpClient = new HttpClient($config);
  }
  
  public function registrarBoleto(array $payload): array {
    $payload["environment"] = $this->config->getEnvironment();
    $uri = $this->config->getBilletRegisterUrl();
    return $this->httpClient->post($uri, $payload);
  }
  
  public function boletoPdf(string $billId, int $payerDocumentNumber): array 
  {    
    $uri = $this->config->getBillManagementUrl()."/bills/{$billId}/bank_spips";
    return $this->httpClient->post($uri, ['payerDocumentNumber' => $payerDocumentNumber]);
  }

}