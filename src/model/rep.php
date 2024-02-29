<?php

setlocale(LC_MONETARY,'pt_BR');

class rep{

    private ?int $id;

    private string $vincPF;

    private string $dt_rep;

    private string $doc_hab;

    private string $dest;
    
    private string $valor;

    public function __construct(?int $id, string $vincPF, string $dt_rep, string $doc_hab, string $dest , string $valor)
    {
        $this->id = $id;
        $this->vincPF = $vincPF;
        $this->dest = $dest;
        $this->valor = $valor;
        $this->dt_rep = $dt_rep;
        $this->doc_hab = $doc_hab;
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
    
    public function getDest(): string{
        return $this->dest;
    }

    public function getValue(): string{
        return $this->valor;
    }

    public function getDate(): string{
        return $this->dt_rep;
    }

    public function getDocHab(): string{
        return $this->doc_hab;
    }

    public function isFull(): bool{
        if(empty($this->vincPF) || empty($this->dest) || empty($this->valor) || empty($this->dt_rep) || empty($this->doc_hab)){
            return false;
        }
        return true;
    }

}

?>