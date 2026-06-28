<?php
namespace App\Controller;

use App\Model\Repository\{SignalementRepository, CategorieRepository};
use App\Exception\EntityNotFoundException;

class ApiController {

    private function json(mixed $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function signalements(): void {
        $repo   = new SignalementRepository();
        $result = $repo->findByFilters([], 1, 100);
        $data   = array_map(fn($s) => [
            'id'          => $s->getId(),
            'titre'       => $s->getTitre(),
            'description' => $s->getDescription(),
            'adresse'     => $s->getAdresse(),
            'statut'      => $s->getStatut(),
            'priorite'    => $s->getPriorite(),
            'categorie_id'=> $s->getCategorieId(),
            'citoyen_id'  => $s->getCitoyenId(),
            'created_at'  => $s->getCreatedAt()->format('Y-m-d H:i:s'),
        ], $result['data']);

        $this->json([
            'success' => true,
            'total'   => $result['total'],
            'pages'   => $result['pages'],
            'data'    => $data,
        ]);
    }

    public function signalement(string $id): void {
        try {
            $repo = new SignalementRepository();
            $s    = $repo->findById((int)$id);
            $this->json([
                'success' => true,
                'data'    => [
                    'id'          => $s->getId(),
                    'titre'       => $s->getTitre(),
                    'description' => $s->getDescription(),
                    'adresse'     => $s->getAdresse(),
                    'statut'      => $s->getStatut(),
                    'priorite'    => $s->getPriorite(),
                    'categorie_id'=> $s->getCategorieId(),
                    'citoyen_id'  => $s->getCitoyenId(),
                    'created_at'  => $s->getCreatedAt()->format('Y-m-d H:i:s'),
                ],
            ]);
        } catch (EntityNotFoundException $e) {
            $this->json([
                'success' => false,
                'message' => 'Signalement introuvable',
            ], 404);
        }
    }

    public function categories(): void {
        $cats = (new CategorieRepository())->findAll();
        $data = array_map(fn($c) => [
            'id'               => $c->getId(),
            'nom'              => $c->getNom(),
            'type'             => $c->getType(),
            'description'      => $c->getDescription(),
            'delai_traitement' => $c->getDelaiTraitement(),
            'priorite_defaut'  => $c->getPrioriteDefaut(),
            'icone'            => $c->getIcone(),
        ], $cats);

        $this->json([
            'success' => true,
            'total'   => count($data),
            'data'    => $data,
        ]);
    }

    public function stats(): void {
        $stats = (new SignalementRepository())->getStatistiques();
        $this->json([
            'success' => true,
            'data'    => [
                'par_statut'    => $stats['par_statut'],
                'par_categorie' => $stats['par_categorie'],
            ],
        ]);
    }
}