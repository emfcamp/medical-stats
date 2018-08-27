<?php

namespace EMFCamp\Medical;

use Carbon\Carbon;
use EMFCamp\Medical\ePrfPrimary;
use EMFCamp\Medical\ePrfSerious;
use EMFCamp\Medical\ePrfDischarge;
use EMFCamp\Medical\ePrfSecondary;
use EMFCamp\Medical\ePrfTreatment;

class ePrf
{
    private $id;

    private $date;
    private $year;
    private $month;
    private $day;
    private $hour;

    private $category;
    private $severity;
    private $riddor;

    private $primary;
    private $secondary;
    private $treatment;
    private $serious;
    private $discharge;

    private $categories = [
        'Welfare'   =>  [
            'severities'    =>  ['Normal'],
        ],
        'First Aid'   =>  [
            'severities'    =>  ['Minor','Serious'],
        ],
        'On Call'   =>  [
            'severities'    =>  ['HCP', 'Ambulance'],
        ],
        'Off Site'   =>  [
            'severities'    =>  ['Temporary', 'Permanent', 'Death'],
        ],
    ];

    public function __construct()
    {
        $this->category = false;
        $this->severity = false;
        $this->riddor = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateString()
    {
        return $this->date->toIso8601String();
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getPossibleCategories()
    {
        return $this->categories;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return ePRF
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }
    
    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set severity
     *
     * @param string $severity
     *
     * @return ePRF
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
    
        return $this;
    }
    
    /**
     * Get severity
     *
     * @return string
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set riddor
     *
     * @param boolean $riddor
     *
     * @return ePRF
     */
    public function setRiddor($riddor)
    {
        $this->riddor = $riddor;
    
        return $this;
    }
    
    /**
     * Get riddor
     *
     * @return boolean
     */
    public function getRiddor()
    {
        return $this->riddor;
    }

    public function createFromXML($xmlString)
    {
        $xml = simplexml_load_string($xmlString);

        if ($xml === false) {
            return false;
        }

        $this->id = (string)$xml->uuid;

        $this->date = $this->parseDate($xml->incident->time);
        $this->processDate();

        $this->primary = new ePrfPrimary($xml->primary);
        $this->secondary = new ePrfSecondary($xml->secondary);
        $this->treatment = new ePrfTreatment($xml->treatment);
        $this->serious = new ePrfSerious($xml->serious);
        $this->discharge = new ePrfDischarge($xml->discharge);

        return true;
    }

    public function getPrimary()
    {
        return $this->primary;
    }

    public function getSecondary()
    {
        return $this->secondary;
    }

    public function getTreatment()
    {
        return $this->treatment;
    }

    public function getSerious()
    {
        return $this->serious;
    }

    public function getDischarge()
    {
        return $this->discharge;
    }

    private function parseDate($prfDate)
    {
        // prfDate in this format:
        // Sun Aug 07 12:45:07 Europe/London 2016
        // Timezone is Europe/London
        
        $date = Carbon::createFromFormat("D M d H:i:s e Y", $prfDate);

        return $date;
    }

    private function processDate()
    {
        $this->year = $this->date->year;
        $this->month = $this->date->month;
        $this->day = $this->date->day;
        $this->hour = $this->date->hour;
    }
}