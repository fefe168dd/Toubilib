<?php 
namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\ServiceRdvInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepository;
use toubilib\core\domain\entities\rdv\RendezVous;
use toubilib\core\application\ports\api\dto\RdvDTO;
use DateTime;
class ServiceRdv implements ServiceRdvInterface {
    private RdvRepository $rdvRepository;

    public function __construct(RdvRepository $rdvRepository) {
        $this->rdvRepository = $rdvRepository;
    }

    public function listerRdvOcuppePraticienParDate(DateTime $debut, DateTime $fin, string $practicien_id): array {
        $rdvs = $this->rdvRepository->listerRdvOcuppePraticienParDate($debut, $fin, $practicien_id);
        $rdvsDTO = [];
        foreach ($rdvs as $rdv) {
            $rdvsDTO[] = new RdvDTO($rdv);
        }
        return $rdvsDTO;
    }
}