<?php

class progFin{

    private ?int $id;

    private string $numero;

    private float $valor;

    private string $conta;

    private string $resp;

    private float $disp;

    private string $dt_siafi;

    public function __construct(?int $id, string $numero, float $valor, string $dt_siafi, string $conta, string $resp, float $disp)
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->conta = $conta;
        $this->resp = $resp;
        $this->valor = $valor;
        $this->disp = $disp;
        $this->dt_siafi = $dt_siafi;
   }
   
   public function getFormatedValue(float $valor): string
   {
       return str_replace('#','.', str_replace('.',',', str_replace(',', '#', number_format($valor, 2))));
   }

   public function getFormatedDate(string $date): string{
        return date("d/m/Y", strtotime($date));
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