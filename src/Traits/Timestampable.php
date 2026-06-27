<?php
namespace App\Traits;
trait Timestampable {
private ?\DateTime $createdAt = null;
private ?\DateTime $updatedAt = null;
public function getCreatedAt(): ?\DateTime { return $this->createdAt; }
public function getUpdatedAt(): ?\DateTime { return $this->updatedAt; }
public function setCreatedAt(\DateTime $dt): void { $this->createdAt = $dt; }
public function setUpdatedAt(\DateTime $dt): void { $this->updatedAt = $dt; }
public function touchUpdatedAt(): void {
$this->updatedAt = new \DateTime();
}
}