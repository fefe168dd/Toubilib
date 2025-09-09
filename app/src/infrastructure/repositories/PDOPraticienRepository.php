<?php

namespace toubilib\infra\repositories;

use toubilib\core\application\ports\spi\praticienRepository ;

class PDOPraticienRepository implements praticienRepository
{


    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listerPraticiens(): array {
        $stmt = $this->pdo->query('SELECT * FROM praticiens');
        $praticiensData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $praticiens = [];
        foreach ($praticiensData as $data) {
            $praticien = new \toubilib\core\domain\entities\praticien\Praticien(
                $data['id'],
                $data['nom'],
                $data['prenom'],
                $data['email'],
                $data['telephone'],
                $data['specialite_id'] 
            );
            $praticiens[] = $praticien;
        }

        return $praticiens;
    }
 
}