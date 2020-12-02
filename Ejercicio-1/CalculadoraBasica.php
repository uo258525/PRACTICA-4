<?php

session_start();
class CalculadoraBasica
{
    private $memory;
    private $display;

    public function __construct()
    {
        $this->display = "";
        $this->memory = "";
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function getMemory()
    {
        return $this->memory;
    }

    public function digit($digit)
    {
        if ($this->display === 0) {
            $this->display = $digit;
        } else {
            $this->display .= $digit;
        }
    }
    public function operator($op)
    {
        switch ($op) {
            case ("+"):
                $this->display = $this->display . "+";
                break;
            case ("-"):
                $this->display = $this->display . "-";
                break;
            case ("*"):
                $this->display = $this->display . "*";
                break;
            case ("/"):
                $this->display = $this->display . "/";
                break;
        }
    }
    public function mrc()
    {
        $this->display = $this->memory;
        $this->memory = 0;
    }
    public function mMas()
    {
        try {
            $this->memory += eval("return $this->display;");
            $this->cleanDisplay();
        } catch (Exception $e) {
            echo '<script>alert("Operación incorrecta")</script>';
        }
    }
    public function mMenos()
    {
        try {
            $this->memory -= eval("return $this->display;");
            $this->cleanDisplay();
        } catch (Exception $e) {
            echo '<script>alert("Operación incorrecta")</script>';
        }
    }

    public function equals(){
        try{

        }
        catch(Exception $e){

        }

    }

    public function cleanDisplay(){
        $this->display="0";
    }
}
