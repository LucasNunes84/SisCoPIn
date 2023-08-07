<?php
    class progFinRepository{
            
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function openPF(){
            $sql1 = "SELECT 
                con_PF.id_reg, con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND disp_PF.disp>0"
            ;

            $statement = $this->pdo -> query($sql1);
            $progFin = $statement -> fetchAll(PDO::FETCH_ASSOC);
            
            $dadosPF = array_map(function ($PF){
                return new progFin(
                    $PF['id_reg'],
                    $PF['numero'],
                    $PF['valor'],
                    $PF['dt_siafi'],
                    $PF['conta'],
                    $PF['resp'],
                    $PF['disp']
                );
            }, $progFin);

            return $dadosPF;
        }

        public function closedPF(){
            $sql1 = "SELECT 
                con_PF.id_reg, con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND disp_PF.disp=0"
            ;

            $statement = $this->pdo->query($sql1);
            $closedProgFin = $statement -> fetchAll(PDO::FETCH_ASSOC);

            $dadosClosedPF = array_map(function ($PF){
                return new progFin(
                    $PF['id_reg'],
                    $PF['numero'],
                    $PF['valor'],
                    $PF['dt_siafi'],
                    $PF['conta'],
                    $PF['resp'],
                    $PF['disp']
                );
            }, $closedProgFin);

            return $dadosClosedPF;
        }

        public function salvar(progFin $progFin){
            $sql = "INSERT INTO con_PF (numero, valor, dt_siafi, conta, resp) VALUES (?,?,?,?,?)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $progFin->getNumber());
            $statement->bindValue(2, $progFin->getValue());
            $statement->bindValue(3, $progFin->getDate());
            $statement->bindValue(4,$progFin->getConta());
            $statement->bindValue(5, $progFin->getResp());
            $statement->execute();
        }
    }
?>