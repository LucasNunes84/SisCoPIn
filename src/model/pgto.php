<?php

setlocale(LC_MONETARY,'pt_BR');

class pgto{

    private ?int $id;

    private string $vincPF;

    private string $valor;

    private string $cred;

    private string $dt_pgto;

    public function __construct(?int $id, string $vincPF, string $valor, string $dt_pgto, string $cred)
    {
        $this->id = $id;
        $this->vincPF = $vincPF;
        $this->cred = $cred;
        $this->valor = $valor;
        $this->dt_pgto = $dt_pgto;
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

    public function getVincPF(): string{
        return $this->vincPF;
    }

    public function getConta(): string{
        return $this->conta;
    }
    
    public function getCred(): string{
        return $this->cred;
    }

    public function getValue(): string{
        return $this->valor;
    }

    public function getDate(): string{
        return $this->dt_pgto;
    }

    public function isFull(): bool{
        if(empty($this->vincPF) || empty($this->cred) || empty($this->valor) || empty($this->dt_pgto)){
            return false;
        }
        return true;
    }

}

?>