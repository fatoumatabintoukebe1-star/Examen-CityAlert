<?php
namespace App\Model\EntitY;
use App\Traits\Timestampable;
class Commentaire {
use Timestampable;
private ?int $id = null;
private string $contenu;
private int $auteurId;
private int $signalementId;
private string $auteurNom = '';
private string $auteurRole = '';
public function __construct(string $contenu, int $auteurId, int $signalementId) {
$this->contenu = $contenu;
$this->auteurId = $auteurId;
$this->signalementId = $signalementId;
$this->setCreatedAt(new \DateTime());
$this->setUpdatedAt(new \DateTime());
}
public function getId(): ?int { return $this->id; }
public function getContenu(): string { return $this->contenu; }
public function getAuteurId(): int { return $this->auteurId; }
public function getSignalementId(): int{ return $this->signalementId; }
public function getAuteurNom(): string { return $this->auteurNom; }
public function getAuteurRole(): string{ return $this->auteurRole; }
public function setId(int $id): void { $this->id = $id; }
public function setAuteurNom(string $n): void { $this->auteurNom = $n; }
public function setAuteurRole(string $r): void { $this->auteurRole = $r; }
}