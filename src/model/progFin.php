<?php

setlocale(LC_MONETARY,'pt_BR');

class progFin{

    private ?int $id;

    private string $numero;

    private string $valor;

    private string $conta;

    private string $resp;

    private string $disp;

    private string $dt_siafi;

    public function __construct(?int $id, string $numero, string $valor, string $dt_siafi, string $conta, string $resp, string $disp)
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->conta = $conta;
        $this->resp = $resp;
        $this->valor = $valor;
        $this->disp = $disp;
        $this->dt_siafi = $dt_siafi;
   }

   public function getId(): string
   {
        return $this->id;
   }
   
   public function getFormatedValue(string $valor): string
   {
    //    return str_replace('#','.', str_replace('.',',', str_replace(',', '#', number_format($valor, 2))));
    //    return str_replace('.',',',$valor);
        $fmt = numfmt_create('pt_BR',NumberFormatter::CURRENCY);
        return numfmt_format_currency($fmt, $valor, "BRL");
   }

   public function getFormatedDate(string $date): string{
        return date("d/m/Y", strtotime($date));
   }

    public function getYearDate(string $date): string{
        return date("Y", strtotime($date));
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

    public function getValue(): string{
        return $this->valor;
    }

    public function getDisp(): string{
        return $this->disp;
    }

    public function getDate(): string{
        return $this->dt_siafi;
    }

    public function isFull(): bool{
        if(empty($this->numero) || empty($this->valor) || empty($this->conta) || empty($this->resp) ||empty($this->dt_siafi)){
            return false;
        }
        return true;
    }

}

?>