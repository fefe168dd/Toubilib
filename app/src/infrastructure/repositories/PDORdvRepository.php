<?php 
namespace toubilib\infra\repositories;

use DateTime;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepository;
use toubilib\core\domain\entities\rdv\RendezVous;

class PDORdvRepository implements RdvRepository {
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

   /* lister les créneaux de rdvs déjà occupés d’un praticien sur une période donnée (date de début date de fin),*/
    public function listerRdvOcuppePraticienParDate(DateTime $debut, DateTime $fin, string $practicien_id): array {
        $stmt = $this->pdo->prepare('
            SELECT id, praticien_id, patient_id, date_debut, date_fin 
            FROM rendez_vous 
            WHERE praticien_id = :praticien_id 
              AND date_debut >= :debut 
              AND date_fin <= :fin
            ORDER BY date_debut
        ');
        $stmt->execute([
            ':praticien_id' => $practicien_id,
            ':debut' => $debut->format('Y-m-d H:i:s'),
            ':fin' => $fin->format('Y-m-d H:i:s')
        ]);
        $rdvs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rdvs[] = new RendezVous(
                $row['id'],
                $row['praticien_id'],
                $row['patient_id'],
                new DateTime($row['date_debut']),
                new DateTime($row['date_fin']),
                $row['motif_visite']
            );
        }
        return $rdvs;
    }
}