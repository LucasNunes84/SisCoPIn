<?php

setlocale(LC_MONETARY,'pt_BR');

class conta{

    private string $valorTotal;

    private string $conta;

    private string $valorRestante;

    public function __construct(string $valorTotal, string $conta, string $valorRestante)
    {
        $this->valorTotal = $valorTotal;
        $this->valorRestante = $valorRestante;
        $this->conta = $conta;
   }
   
   public function getFormatedValue(string $valor): string
   {
        $fmt = numfmt_create('pt_BR',NumberFormatter::CURRENCY);
        return numfmt_format_currency($fmt, $valor, "BRL");
   }

    public function getConta(): string{
        return $this->conta;
    }

    public function getTotalValue(): string{
        return $this->valorTotal;
    }

    public function getRestante(): string{
        return $this->valorRestante;
    }

}

?>