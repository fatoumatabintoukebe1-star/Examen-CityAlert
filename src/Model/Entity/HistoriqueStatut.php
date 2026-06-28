<?php
namespace App\Model\Entity;
class HistoriqueStatut {
private ?int $id = null;
private string $ancienStatut;
private string $nouveauStatut;
private ?string $commentaire = null;
private int $agentId;
private int $signalementId;
private \DateTime $dateChangement;
public function __construct(int $signalementId, int $agentId,
string $ancien, string $nouveau,
?string $commentaire = null) {
$this->signalementId = $signalementId;
$this->agentId = $agentId;
$this->ancienStatut = $ancien;
$this->nouveauStatut = $nouveau;
$this->commentaire = $commentaire;
$this->dateChangement = new \DateTime();
}
public function getId(): ?int { return $this->id; }
public function getAncienStatut(): string { return $this->ancienStatut; }
public function getNouveauStatut(): string{ return $this->nouveauStatut; }
public function getCommentaire(): ?string { return $this->commentaire; }
public function getAgentId(): int { return $this->agentId; }
public function getSignalementId(): int{ return $this->signalementId; }
public function getDateChangement(): \DateTime { return $this->dateChangement; }
public function setId(int $id): void { $this->id = $id; }
}