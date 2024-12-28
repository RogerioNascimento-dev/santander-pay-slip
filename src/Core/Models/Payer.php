<?php 
namespace SantanderPaySlip\Core\Models;

class Payer {
  private string $name;
  private string $documentType;
  private string $documentNumber;
  private string $address;
  private string $neighborhood;
  private string $city;
  private string $state;
  private string $zipCode;

  public function setName(string $name): void {
    $this->name = $name;
  }

  public function setDocumentType(string $documentType): void {
      $this->documentType = $documentType;
  }

  public function setDocumentNumber(string $documentNumber): void {
      $this->documentNumber = $documentNumber;
  }

  public function setAddress(string $address): void {
      $this->address = $address;
  }

  public function setNeighborhood(string $neighborhood): void {
      $this->neighborhood = $neighborhood;
  }

  public function setCity(string $city): void {
      $this->city = $city;
  }

  public function setState(string $state): void {
      $this->state = $state;
  }

  public function setZipCode(string $zipCode): void {
      $this->zipCode = $zipCode;
  }

  public function toArray(): array {
      return [
          'name'           => $this->name,
          'documentType'   => $this->documentType,
          'documentNumber' => $this->documentNumber,
          'address'        => $this->address,
          'neighborhood'   => $this->neighborhood,
          'city'           => $this->city,
          'state'          => $this->state,
          'zipCode'        => $this->zipCode,
      ];
    }
}