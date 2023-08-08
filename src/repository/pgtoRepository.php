<?php
    class pgtoRepository{
            
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }


        public function salvar(pgto $pgto){
            $sql = "SELECT con_PF.id_reg, disp_PF.id_disp, disp_PF.disp FROM con_PF, disp_PF WHERE con_PF.numero='". $pgto->getVincPF() ."' AND con_PF.id_reg=disp_PF.pf_reg"; 
            $statement = $this->pdo->query($sql);
            $pf = $statement -> fetch(PDO::FETCH_ASSOC);
            if($pf['disp']>=$pgto->getValue()){
                $sql = "INSERT INTO pgto_PF (id_pgto_pf, valor_pgto, dt_pgto, credor) VALUES (?,?,?,?)";  
                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(1, $pf['id_disp']);
                $statement->bindValue(2, $pgto->getValue());
                $statement->bindValue(3, $pgto->getDate());
                $statement->bindValue(4, $pgto->getCred());
                $statement->execute();
                $sql = "UPDATE disp_pf SET disp=".($pf['disp']-$pgto->Getvalue())." WHERE (id_disp= '".$pf['id_disp']."');";
                $statement = $this->pdo->query($sql);
            }

        }
    }
?>