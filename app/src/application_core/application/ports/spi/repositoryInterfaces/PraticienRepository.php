<?php
 namespace toubilib\core\application\ports\spi;

use toubilib\core\domain\entities\praticien\Praticien;

interface praticienRepository{
    /**
     * @return Praticien[]
     */
    public function listerPraticiens(): array;
}

