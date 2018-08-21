<?php

namespace EMFCamp\Medical;

class ePrfPrimary extends ePrfSection
{
    private $presenting; // text
    private $response; // Alert / Voice / Pain / None
    private $capacity; // Yes / No
    private $consent; // Yes / No
    private $airway; // Clear / Obstructed
    private $breathing; // Normal / Shallow / Agonal / Rapid / Absent
    private $circulation; // Normal / Pale / Flushed / Cyanosed
    private $externalBleeding; // Yes / No
    private $consciousnessLoss; // Yes / No
    private $alcoholDrugsSuspected; // Yes / No

    public function __construct($xml)
    {
        $this->presenting = $this->extractText($xml->presenting);
        $this->response = $this->extractChoice($xml->response);
        $this->capacity = $this->checkCapacityConsent($xml->capacity);
        $this->consent = $this->checkCapacityConsent($xml->consent);
        $this->airway = $this->extractChoice($xml->airway);
        $this->breathing = $this->extractChoice($xml->breathing);
        $this->circulation = $this->extractChoice($xml->circulation);
        $this->externalBleeding = $this->checkYesNo($xml->external);
        $this->consciousnessLoss = $this->checkYesNo($xml->consciousness);
        $this->alcoholDrugsSuspected = $this->checkYesNo($xml->alcohol_drugs);
    }

    private function checkCapacityConsent($value)
    {
        // this field is broken - outputs ERROR when not used at all!
        // we are going to assume capacity and consent at this point
        if ($value == "ERROR") {
            return true;
        } else {
            // just in case it starts working again
            return $this->checkYesNo($value);
        }
    }
}