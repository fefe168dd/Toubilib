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

    public function listerPraticiens(): array {
        $stmt = $this->pdo->query('SELECT * FROM praticien');
        $praticiensData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $praticiens = [];
        foreach ($praticiensData as $data) {
            $specialite = $this->specialiteParId((int)$data['specialite_id']);
            
            $praticien = new \toubilib\core\domain\entities\praticien\Praticien(
                $data['id'],
                $data['nom'],
                $data['prenom'],
                $data['ville'] ,
                $data['email'],
                $specialite
            );
            $praticiens[] = $praticien;
        }

        return $praticiens;
    }
}