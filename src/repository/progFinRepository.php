<?php
    class progFinRepository{
            
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function allPF(){
            $sql1 = "SELECT 
                con_PF.id_reg, con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg"
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
            $statement->bindValue(1, $progFin->getYearDate($progFin->getDate()).'PF'.sprintf('%06d', $progFin->getNumber()));
            $statement->bindValue(2, $progFin->getValue());
            $statement->bindValue(3, $progFin->getDate());
            $statement->bindValue(4,$progFin->getConta());
            $statement->bindValue(5, $progFin->getResp());
            $statement->execute();
            $id = $this->pdo->lastInsertId();
            $sql = "INSERT INTO disp_PF (pf_reg, disp) VALUES (?,?)";
            $statement = $this->pdo->prepare($sql);
            $statement->bindValue(1, $id);
            $statement->bindValue(2, $progFin->getDisp());
            $statement->execute();
        }
        
        //RETORNA VALORES RECEBIDOS E DISPONIVEIS POR CONTA
        public function contaTotalValue(string $searchConta){
            $sql1 = "SELECT 
                con_PF.valor, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND con_PF.conta='".$searchConta."'"
            ;

            $statement = $this->pdo->query($sql1);
            $pfByConta = $statement -> fetchAll(PDO::FETCH_ASSOC);

            $totalRecebidoConta = 0;
            $restanteConta = 0;

            foreach($pfByConta as $PF){
                $totalRecebidoConta = $totalRecebidoConta + $PF['valor'];
                $restanteConta = $restanteConta + $PF['disp'];
            }
            $conta = new conta($totalRecebidoConta, $searchConta, $restanteConta);
            return $conta;
        }

        public function allContasDB(){
            $sql1 = "SELECT DISTINCT con_PF.conta FROM con_PF";
            $statement = $this->pdo->query($sql1);
            $allContas = $statement -> fetchAll(PDO::FETCH_ASSOC);
            return $allContas;
        }
    }
?>