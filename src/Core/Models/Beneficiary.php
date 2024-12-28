<?php 
namespace SantanderPaySlip\Core\Models;

class Beneficiary {
  private string $name;
  private string $documentType;
  private string $documentNumber; 

  public function setName(string $name): void {
    $this->name = $name;
  }
  public function setDocumentType(string $documentType): void {
      $this->documentType = $documentType;
  }
  public function setDocumentNumber(string $documentNumber): void {
      $this->documentNumber = $documentNumber;
  }
  public function toArray(): array {
      return [
          'name'           => $this->name,
          'documentType'   => $this->documentType,
          'documentNumber' => $this->documentNumber          
      ];
    }
}