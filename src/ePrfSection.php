<?php

namespace EMFCamp\Medical;

use Carbon\Carbon;

class ePrfSection
{

    protected function checkBox($value)
    {
        // actually, this can be yes or unknown
        // Athis is basically the same logic as YesNo!
        
        return $this->checkYesNo($value);
    }

    protected function checkYesNo($value)
    {
        if ($value == "yes") {
            return true;
        } else {
            return false;
        }
    }

    protected function parseInnerDate($dateString)
    {
        // innerDates in this format:
        // 2016-08-08 14:49:34
        // Timezone is Europe/London
        
        $date = Carbon::createFromFormat("Y-m-d H:i:s", $dateString, new \DateTimeZone('Europe/London'));

        return $date;
    }

    protected function extractText($xml)
    {
        return (string)$xml;
    }

    protected function extractInteger($xml)
    {
        return intval($this->extractText($xml));
    }

    protected function extractChoice($xml)
    {
        return $this->extractText($xml);
    }
}