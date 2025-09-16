<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepository;

class ServicePraticien implements ServicePraticienInterface
{
    private praticienRepository $PraticienRepository;

    public function __construct(praticienRepository $PraticienRepository)
    {
        $this->PraticienRepository = $PraticienRepository;
    }

    public function listerPraticiens(): array {
        return $this->PraticienRepository->listerPraticiens();
    }
}