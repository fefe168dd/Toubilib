<?php
 namespace toubilib\core\application\ports\spi\repositoryInterfaces;

use toubilib\core\domain\entities\praticien\Praticien;

interface PraticienRepository{
    /**
     * @return Praticien[]
     */
    public function listerPraticiens(): array;
}

