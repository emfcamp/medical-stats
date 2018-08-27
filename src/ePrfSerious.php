<?php

namespace EMFCamp\Medical;

class ePrfSerious extends ePrfSection
{
    private $ambulance; // Yes / No
    private $ambulanceArrived; // date: 2016-08-08 14:49:34
    private $ambulanceDeparted; // date: 2016-08-08 14:49:34
    private $cpr; // Yes / No
    private $cprStarted; // date: 2016-08-08 14:49:34
    private $defib; // Yes / No
    private $defibNumShocks; // number
    private $witnessedCollapse; // Yes / No


    public function __construct($xml)
    {
        $this->ambulance = $this->checkAmbulance($xml->ambulance_called);
        $this->ambulanceArrived = $this->parseInnerDate($xml->ambulance_arrived);
        $this->ambulanceDeparted = $this->parseInnerDate($xml->ambulance_departed);
        $this->cpr = $this->checkYesNo($xml->cpr);
        $this->cprStarted = $this->parseInnerDate($xml->cpr_started);
        $this->defib = $this->checkYesNo($xml->defib_used);
        $this->defibNumShocks = $this->extractInteger($xml->defib_shocks);
        $this->witnessedCollapse = $this->checkYesNo($xml->witnessed_collapse);
    }

    /**
     * Get ambulance
     *
     * @return boolean
     */
    public function getAmbulance()
    {
        return $this->ambulance;
    }

    /**
     * Get ambulanceArrived
     *
     * @return Carbon
     */
    public function getAmbulanceArrived()
    {
        return $this->ambulanceArrived;
    }

    /**
     * Get ambulanceDeparted
     *
     * @return Carbon
     */
    public function getAmbulanceDeparted()
    {
        return $this->ambulanceDeparted;
    }

    /**
     * Get cpr
     *
     * @return boolean
     */
    public function getCpr()
    {
        return $this->cpr;
    }

    /**
     * Get cprStarted
     *
     * @return Carbon
     */
    public function getCprStarted()
    {
        return $this->cprStarted;
    }

    /**
     * Get defib
     *
     * @return boolean
     */
    public function getDefib()
    {
        return $this->defib;
    }

    /**
     * Get defibNumShocks
     *
     * @return integer
     */
    public function getDefibNumShocks()
    {
        return $this->defibNumShocks;
    }

    /**
     * Get witnessedCollapse
     *
     * @return boolean
     */
    public function getWitnessedCollapse()
    {
        return $this->witnessedCollapse;
    }

    private function checkAmbulance($value)
    {
        // this field is broken - outputs ERROR when not used at all!
        // we are going to assume an ambulance wasn't called...
        if ($value == "ERROR") {
            return false;
        } else {
            // just in case it starts working again
            return $this->checkYesNo($value);
        }
    }
}