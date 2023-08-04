<?php

class progFin{
    private string $numero;

    private float $valor;

    private string $conta;

    private string $resp;

    private float $disp;

    private string $dt_siafi;


    //Data SIAFI adicionada
    public function __construct(string $numero, float $valor, string $dt_siafi, string $conta, string $resp, float $disp)
    {
        $this->numero = $numero;
        $this->conta = $conta;
        $this->resp = $resp;
        $this->valor = $valor;
        $this->disp = $disp;
        $this->dt_siafi = $dt_siafi;
   }

    public function getNumber(): string{
        return $this->numero;
    }

    public function getConta(): string{
        return $this->conta;
    }
    
    public function getResp(): string{
        return $this->resp;
    }

    public function getValue(): float{
        return $this->valor;
    }

    public function getDisp(): float{
        return $this->disp;
    }

    public function getDate(): string{
        return $this->dt_siafi;
    }    
}

?>