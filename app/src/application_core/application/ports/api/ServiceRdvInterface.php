<?php 
namespace toubilib\core\application\ports\api;
use toubilib\core\domain\entities\rdv\RendezVous;
use toubilib\core\application\ports\api\dto\RdvDTO;
use DateTime;
interface ServiceRdvInterface {
    public function listerRdvOcuppePraticienParDate(DateTime $debut, DateTime $fin, string $practicien_id): array;
    
    /**
     * Consulter un rendez-vous par son identifiant
     */
    public function consulterRendezVousParId(string $id): ?RdvDTO;
}