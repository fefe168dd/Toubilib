<?php

namespace toubilib\infra\repositories;

use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepository ;
use toubilib\core\domain\entities\praticien\Specialite;

class PDOPraticienRepository implements PraticienRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function specialiteParId(int $id): ?\toubilib\core\domain\entities\praticien\Specialite {
        $stmt = $this->pdo->prepare('SELECT * FROM specialite WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new \toubilib\core\domain\entities\praticien\Specialite(
                $data['id'],
                $data['libelle'],
                $data['description']
            );
        }

        return null;
    }
    public function motifVisiteParId(int $id): ?\toubilib\core\domain\entities\praticien\MotifVisite {
        $stmt = $this->pdo->prepare('SELECT * FROM  praticien2motif WHERE id = :praticien_id');
        $stmt->execute(['id' => $id]);
        $stmt = $this->pdo->prepare('SELECT * FROM motif_visite WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new \toubilib\core\domain\entities\praticien\MotifVisite(
                $data['id'],
                $data['specialite_id'],
                $data['libelle']
            );
        }
        return null;

        
    }

    public function moyenPaiementParId(int $id): ?\toubilib\core\domain\entities\praticien\MoyenPaiement {
        $stmt = $this->pdo->prepare('SELECT * FROM praticien2moyen WHERE id = :praticien_id');
        $stmt->execute(['id' => $id]);
        $stmt = $this->pdo->prepare('SELECT * FROM moyen_paiement WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new \toubilib\core\domain\entities\praticien\MoyenPaiement(
                $data['id'],
                $data['libelle']
            );
        }
        return null;
       
    }

    public function listerPraticiens(): array {
        $stmt = $this->pdo->query('SELECT * FROM praticien');
        $praticiensData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $praticiens = [];
        foreach ($praticiensData as $data) {
            $specialite = $this->specialiteParId((int)$data['specialite_id']);
            $motifVisite = $this->motifVisiteParId((int)$data['id']);
            $moyenPaiement = $this->moyenPaiementParId((int)$data['id']);
            
            $praticien = new \toubilib\core\domain\entities\praticien\Praticien(
                $data['id'],
                $data['nom'],
                $data['prenom'],
                $data['ville'] ,
                $data['email'],
                $specialite,
                $motifVisite,
                $moyenPaiement
            );
            $praticiens[] = $praticien;
        }

        return $praticiens;
    }
}