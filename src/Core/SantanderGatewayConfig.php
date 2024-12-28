<?php
namespace SantanderPaySlip\Core;
class SantanderGatewayConfig
{
  private string $clientId;
  private string $clientSecret;
  private string $grantType;
  private string $workspace; 
  private string $sandbox;
  private string $cert;  
  private string $sslKey;  
  
  public function __construct(string $clientId, string $clientSecret, string $grantType, string $cert, string $sslKey, string $workspace, bool $sandbox = true)
  {
    
    $this->clientId     = $clientId;
    $this->clientSecret = $clientSecret;
    $this->grantType    = $grantType;
    $this->cert         = $cert;
    $this->sslKey       = $sslKey;
    $this->workspace    = $workspace;
    $this->sandbox      = $sandbox;
  }

  public function getClientId(): string
  {
    return $this->clientId;
  }
  public function getGrantType(): string
  {
    return $this->grantType;
  }
  public function getWorkspace(): string
  {
    return $this->workspace;
  }
  public function getClientSecret(): string
  {
    return $this->clientSecret;
  }

  public function getClientConfig(): array
  {
    return [
      'base_uri' => $this->getBaseUrl(),
      'cert'     => $this->cert,
      'ssl_key'  => $this->sslKey,
    ];
  }
  public function getBaseUrl(): string
  {
    return 'https://trust-'.$this->getUrlPrefix().'.api.santander.com.br';
  }
  public function getBillManagementUrl(): string
  {
    return "/collection_bill_management/v2";
  }
  public function getBilletRegisterUrl(): string
  {
    return "{$this->getBillManagementUrl()}/workspaces/{$this->workspace}/bank_slips";
  }  
  public function getTokenUrl(): string
  {
    return $this->getBaseUrl().'/auth/oauth/v2/token';
  }
  private function getUrlPrefix(): string
  {
    return $this->sandbox ? 'sandbox' : 'open';
  }
  public function getEnvironment(): string
  {
    return $this->sandbox ? 'TESTE' : 'PRODUCAO';
  }
}