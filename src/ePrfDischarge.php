<?php

namespace EMFCamp\Medical;

use Carbon\Carbon;

class ePrfDischarge extends ePrfSection
{

    private $walkingAided; // unknown or yes
    private $walkingUnaided; // unknown or yes
    private $ownTransport; // unknown or yes
    private $publicTransport; // unknown or yes
    private $ambulance; // unknown or yes
    private $taxi; // unknown or yes
    private $otherTransport; // text
    private $treatmentCompleted; // unknown or yes
    private $advisedFurther; // unknown or yes
    private $hospital; // unknown or yes
    private $reviewLater; // unknown or yes
    private $receivingCentre;// text
    private $timeLeft; // date: 2016-08-08 14:49:34
    private $seenBy; // text
    private $refused; // unknown or yes

    public function __construct($xml)
    {
        $this->walkingAided = $this->checkBox($xml->walking_aided);
        $this->walkingUnaided = $this->checkBox($xml->walking_unaided);
        $this->ownTransport = $this->checkBox($xml->own_transport);
        $this->publicTransport = $this->checkBox($xml->public_transport);
        $this->ambulance = $this->checkBox($xml->ambulance);
        $this->taxi = $this->checkBox($xml->taxi);
        $this->otherTransport = $this->extractText($xml->other);
        $this->treatmentCompleted = $this->checkBox($xml->completed);
        $this->advisedFurther = $this->checkBox($xml->advised);
        $this->hospital = $this->checkBox($xml->hospital);
        $this->reviewLater = $this->checkBox($xml->review);
        $this->receivingCentre = $this->extractText($xml->receiving_centre);
        $this->timeLeft = $this->parseDate($xml->time_left);
        $this->seenBy = $this->extractText($xml->seen_by);
        $this->refused = $this->checkBox($xml->refused);
    }

    // not ideal, copied from ePrf
    private function parseDate($prfDate)
    {
        // prfDate in this format:
        // Sun Aug 07 12:45:07 Europe/London 2016
        // Timezone is Europe/London
        
        $date = Carbon::createFromFormat("D M d H:i:s e Y", $prfDate);

        return $date;
    }
}