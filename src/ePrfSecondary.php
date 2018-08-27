<?php

namespace EMFCamp\Medical;

class ePrfSecondary extends ePrfSection
{

    private $highBloodPressure; // unknown or yes
    private $stroke; // unknown or yes
    private $seizures; // unknown or yes
    private $diabetes; // unknown or yes
    private $cardiac; // unknown or yes
    private $asthma; // unknown or yes
    private $respiratory; // unknown or yes
    private $fast; // unknown or yes
    private $fastOnset; // date: 2016-08-08 14:49:34
    private $allergies; // text
    private $medications; // text
    private $medicalHistory; // text
    private $complaintHistory; // text

    public function __construct($xml)
    {
        $this->highBloodPressure = $this->checkBox($xml->high_blood_pressure);
        $this->stroke = $this->checkBox($xml->stroke);
        $this->seizures = $this->checkBox($xml->seizures);
        $this->diabetes = $this->checkBox($xml->diabetes);
        $this->cardiac = $this->checkBox($xml->cardiac);
        $this->asthma = $this->checkBox($xml->asthma);
        $this->respiratory = $this->checkBox($xml->respiratory);
        $this->fast = $this->checkYesNo($xml->fast);
        $this->fastOnset = $this->parseInnerDate($xml->fast_onset);
        $this->allergies = $this->extractText($xml->allergies);
        $this->medications = $this->extractText($xml->medications);
        $this->medicalHistory = $this->extractText($xml->medical_history);
        $this->complaintHistory = $this->extractText($xml->history_presenting_complaint);
    }

    /**
     * Get highBloodPressure
     *
     * @return boolean
     */
    public function getHighBloodPressure()
    {
        return $this->highBloodPressure;
    }

    /**
     * Get stroke
     *
     * @return boolean
     */
    public function getStroke()
    {
        return $this->stroke;
    }

    /**
     * Get seizures
     *
     * @return boolean
     */
    public function getSeizures()
    {
        return $this->seizures;
    }

    /**
     * Get diabetes
     *
     * @return boolean
     */
    public function getDiabetes()
    {
        return $this->diabetes;
    }

    /**
     * Get cardiac
     *
     * @return boolean
     */
    public function getCardiac()
    {
        return $this->cardiac;
    }

    /**
     * Get asthma
     *
     * @return boolean
     */
    public function getAsthma()
    {
        return $this->asthma;
    }

    /**
     * Get respiratory
     *
     * @return boolean
     */
    public function getRespiratory()
    {
        return $this->respiratory;
    }

    /**
     * Get fast
     *
     * @return boolean
     */
    public function getFast()
    {
        return $this->fast;
    }

    /**
     * Get allergies
     *
     * @return string
     */
    public function getAllergies()
    {
        return $this->allergies;
    }

    /**
     * Get medications
     *
     * @return string
     */
    public function getMedications()
    {
        return $this->medications;
    }

    /**
     * Get medicalHistory
     *
     * @return string
     */
    public function getMedicalHistory()
    {
        return $this->medicalHistory;
    }

    /**
     * Get complaintHistory
     *
     * @return string
     */
    public function getComplaintHistory()
    {
        return $this->complaintHistory;
    }
}