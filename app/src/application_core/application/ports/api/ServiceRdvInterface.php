<?php 
namespace toubilib\core\application\ports\api;
use toubilib\core\domain\entities\rdv\RendezVous;
use DateTime;
interface ServiceRdvInterface {
    public function listerRdvOcuppePraticienParDate(DateTime $debut, DateTime $fin, string $practicien_id): array;
}