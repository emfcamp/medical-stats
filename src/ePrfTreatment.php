<?php

namespace EMFCamp\Medical;

class ePrfTreatment extends ePrfSection
{

    private $airwayOpened; // unknown or yes
    private $woundCleaned; // unknown or yes
    private $woundDressed; // unknown or yes
    private $rice; // unknown or yes
    private $adhesiveDressing; // unknown or yes
    private $sling; // unknown or yes
    private $splint; // unknown or yes
    private $recoveryPosition; // unknown or yes
    private $other; // free text


    public function __construct($xml)
    {
        $this->airwayOpened = $this->checkBox($xml->airway_opened);
        $this->woundCleaned = $this->checkBox($xml->wound_cleaned);
        $this->woundDressed = $this->checkBox($xml->wound_dressed);
        $this->rice = $this->checkBox($xml->rice);
        $this->adhesiveDressing = $this->checkBox($xml->adhesive_dressing);
        $this->sling = $this->checkBox($xml->sling);
        $this->splint = $this->checkBox($xml->splint);
        $this->recoveryPosition = $this->checkBox($xml->recovery_position);
        $this->other = $this->extractText($xml->other);
    }
}