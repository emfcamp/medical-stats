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

    /**
     * Get airwayOpened
     *
     * @return boolean
     */
    public function getAirwayOpened()
    {
        return $this->airwayOpened;
    }

    /**
     * Get woundCleaned
     *
     * @return boolean
     */
    public function getWoundCleaned()
    {
        return $this->woundCleaned;
    }

    /**
     * Get woundDressed
     *
     * @return boolean
     */
    public function getWoundDressed()
    {
        return $this->woundDressed;
    }

    /**
     * Get rice
     *
     * @return boolean
     */
    public function getRice()
    {
        return $this->rice;
    }

    /**
     * Get adhesiveDressing
     *
     * @return boolean
     */
    public function getAdhesiveDressing()
    {
        return $this->adhesiveDressing;
    }

    /**
     * Get sling
     *
     * @return boolean
     */
    public function getSling()
    {
        return $this->sling;
    }

    /**
     * Get splint
     *
     * @return boolean
     */
    public function getSplint()
    {
        return $this->splint;
    }

    /**
     * Get recoveryPosition
     *
     * @return boolean
     */
    public function getRecoveryPosition()
    {
        return $this->recoveryPosition;
    }

    /**
     * Get other
     *
     * @return string
     */
    public function getOther()
    {
        return $this->other;
    }
}