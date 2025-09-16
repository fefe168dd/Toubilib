<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepository;
use toubilib\core\application\ports\api\dto\PraticienDTO;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepository $praticienRepository;

    public function __construct(PraticienRepository $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerPraticiens(): array {
        $praticiens = $this->praticienRepository->listerPraticiens();
        $praticiensDTO = [];
        foreach ($praticiens as $praticien) {
            $praticiensDTO[] = new PraticienDTO($praticien);
        }
        
        return $praticiensDTO;
    }
}