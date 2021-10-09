<?php

class Memento
{
    /** @var integer $height */
    private $height;

    /** @var float $weight */
    private $weight;

    /** @var float $bmi */
    private $bmi;

    /** @var string $system */
    private $system;

    public function __construct($height, $weight, $bmi, $system)
    {
        
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWeight()
    {
        return $this->Weight;
    }

    public function getBmi()
    {
        return $this->bmi;
    }

    public function getSystem()
    {
        return $this->system;
    }

    public function setHeight($height)
    {
        if(is_numeric($height) && intval($height) > 0)
        {
            $this->height = intval($height);
            return true;
        }

        return false;
    }

    public function setWeight($weight)
    {
        if(is_numeric($weight) && floatval($weight) > 0)
        {
            $this->weight = floatval($weight);
            return true;
        }

        return false;
    }

    public function setBmi($bmi)
    {
        if(is_numeric($bmi) && floatval($bmi) > 0)
        {
            $this->bmi = floatval($bmi);
            return true;
        }

        return false;
    }

    public function setSystem($system)
    {
        if(is_string($system))
        {
            $this->system = $system;
            return true;
        }

        return false;
    }
}
