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

    private $primary;
    private $secondary;
    private $treatment;
    private $serious;
    private $discharge;

    public function __construct()
    {
        
    }

    public function getDateString()
    {
        return $this->date->toIso8601String();
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