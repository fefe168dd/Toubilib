<?php

namespace toubilib\core\domain\entities\rdv;

use DateTime;

class RendezVous{
    private ?string $id;
    private string $praticien_id;
    private string $patient_id;
    private DateTime $dateHeureDebut;
    private DateTime $dateHeureFin;
    private string $motif_visite;

    public function __construct(?string $id, string $praticien_id, string $patient_id, DateTime $dateHeureDebut, DateTime $dateHeureFin, string $motif_visite){
        $this->id = $id;
        $this->praticien_id = $praticien_id;
        $this->patient_id = $patient_id;
        $this->dateHeureDebut = $dateHeureDebut;
        $this->dateHeureFin = $dateHeureFin;
        $this->motif_visite = $motif_visite;
    }
    public function getId(): ?string{
        return $this->id;
    }
    public function getPraticienId(): string{
        return $this->praticien_id;
    }
    public function getPatientId(): string{
        return $this->patient_id;
    }
    public function getDateHeureDebut(): DateTime{
        return $this->dateHeureDebut;
    }
    public function getDateHeureFin(): DateTime{
        return $this->dateHeureFin;
    }
    public function getMotifVisite(): string{
        return $this->motif_visite;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }
}