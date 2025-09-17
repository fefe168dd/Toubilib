<?php 
namespace toubilib\core\application\ports\api\dto;

use DateTime;
use toubilib\core\domain\entities\rdv\RendezVous;

class RdvDTO{
    public int $id;
    public DateTime $dateHeureDebut;
    public DateTime $dateHeureFin;
    public int $praticienId;
    public int $patientId;

    public function __construct(RendezVous $rdv){
        $this->id = $rdv->getId();
        $this->dateHeureDebut = $rdv->getDateHeureDebut();
        $this->dateHeureFin = $rdv->getDateHeureFin();
        $this->praticienId = $rdv->getPraticienId();
        $this->patientId = $rdv->getPatientId();
    }
}