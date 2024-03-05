<?php

setlocale(LC_MONETARY,'pt_BR');

class rev{

    private ?int $id;

    private string $vincPF;

    private string $dt_gr;

    private string $gr;
    
    private string $valor;

    public function __construct(?int $id, string $vincPF, string $dt_gr, string $gr , string $valor)
    {
        $this->id = $id;
        $this->vincPF = $vincPF;
        $this->valor = $valor;
        $this->dt_gr = $dt_gr;
        $this->gr = $gr;
   }

   public function getID(){
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

    public function getVincPF(): string{
        return $this->vincPF;
    }

    public function getConta(): string{
        return $this->conta;
    }

    public function getValue(): string{
        return $this->valor;
    }

    public function getDate(): string{
        return $this->dt_gr;
    }

    public function getGR(): string{
        return $this->gr;
    }

    public function isFull(): bool{
        if(empty($this->vincPF) || empty($this->valor) || empty($this->dt_gr) || empty($this->gr)){
            return false;
        }
        return true;
    }

}

?>