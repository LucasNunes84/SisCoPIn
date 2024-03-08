
<?php
    class repRepository{
            
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }


        public function salvar(rep $rep){
            $sql = "SELECT 
                        con_pf.id_reg, disp_pf.id_disp, disp_pf.disp 
                    FROM 
                        con_pf, disp_pf 
                    WHERE 
                        con_pf.numero='". $rep->getVincPF() ."' AND con_pf.id_reg=disp_pf.pf_reg"
                    ; 
            $statement = $this->pdo->query($sql);
            $pf = $statement -> fetch(PDO::FETCH_ASSOC);
            if($pf['disp']>=$rep->getValue()){
                $sql = "INSERT INTO 
                            rep_pf (id_pf, dt_rep, doc_hab, destino, valor) 
                        VALUES 
                            (?,?,?,?,?)"
                        ;

                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(1, $pf['id_disp']);
                $statement->bindValue(2, $rep->getDate());
                $statement->bindValue(3, $rep->getYearDate($rep->getDate()).'PF'.sprintf('%06d', $rep->getDocHab()));
                $statement->bindValue(4, $rep->getDest());
                $statement->bindValue(5, $rep->getValue());
                $statement->execute();

                $sql = "UPDATE 
                            disp_pf 
                        SET 
                            disp=".($pf['disp']-$rep->Getvalue())." 
                        WHERE 
                            (id_disp= '".$pf['id_disp']."');"
                        ;
                $statement = $this->pdo->query($sql);
            }
        }

        public function searchRepFromPF(int $idPF){
            $sql = "SELECT 
                        rep_pf.id_reg, rep_pf.id_pf , rep_pf.dt_rep, rep_pf.doc_hab, rep_pf.destino, rep_pf.valor
                    FROM 
                        rep_pf 
                    WHERE 
                        id_rep_pf='".$idPF
                    ;

            $statement = $this->pdo -> query($sql);
            $selectrep = $statement -> fetchAll(PDO::FETCH_ASSOC);
            
            $dadosrep = array_map(function ($rep){
                return new rep(
                    $rep['id_reg'],
                    $rep['id_pf'],
                    $rep['dt_rep'],
                    $rep['doc_hab'],
                    $rep['destino'],
                    $rep['valor']
                );
            }, $selectrep);

            return $dadosrep;
        }

        public function getRepFromPFID(int $id){
            //busca o id da PF disponivel
            $sql = "SELECT id_disp FROM disp_PF WHERE pf_reg = ".$id;
            //armazena no result
            $statement = $this->pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $sql = "SELECT 
                        rep_pf.id_reg, rep_pf.id_pf, rep_pf.dt_rep, rep_pf.doc_hab, rep_pf.destino, rep_pf.valor
                    FROM 
                        rep_pf 
                    WHERE 
                        validade='S' AND id_pf=".$result['id_disp']
                    ;

            $statement = $this->pdo -> query($sql);
            $selectrep = $statement -> fetchAll(PDO::FETCH_ASSOC);

            $dadosRep = array_map(function ($rep){
                return new rep(
                    $rep['id_reg'],
                    $rep['id_pf'],
                    $rep['dt_rep'],
                    $rep['doc_hab'],
                    $rep['destino'],
                    $rep['valor']
                );
            }, $selectrep);

            return $dadosRep;
        }

        public function deleteFromPF(int $id)
        {
            //busca o id da PF disponivel
            $sql = "SELECT id_disp FROM disp_PF WHERE pf_reg = ".$id;
            //armazena no result
            $statement = $this->pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //deleta onde possui o resultado
            $sql = "UPDATE rep_pf SET validade='N' WHERE id_pf = ".$result['id_disp'];
            $statement = $this->pdo->query($sql);
            //deleta o id da PF disponivel
            $sql = "UPDATE disp_PF SET validade='N' WHERE pf_reg = ".$id;
            $statement = $this->pdo->query($sql);

        }
        public function deleteFromID(int $idrep, int $idPF)
        {
            //busca pega o valor do rep
            $sql = "SELECT valor FROM rep_pf WHERE id_reg = ".$idrep;
            //armazena no valorrep
            $statement = $this->pdo->query($sql);
            $valorrep = $statement->fetch(PDO::FETCH_ASSOC);
            //busca pega o valor disp na PF
            $sql = "SELECT disp FROM disp_PF WHERE pf_reg = ".$idPF;
            //armazena no dispPF
            $statement = $this->pdo->query($sql);
            $dispPF = $statement->fetch(PDO::FETCH_ASSOC);
            //soma o valor do rep a ser deletado
            $dispPF['disp'] = $dispPF['disp'] + $valorrep['valor'];
            //deleta o rep selecionado
            $sql = "UPDATE rep_pf SET validade='N' WHERE id_reg = ".$idrep;
            $statement = $this->pdo->query($sql);
            //altera o valor disponivel da PF
            $sql = "UPDATE disp_PF SET disp=".$dispPF['disp']." WHERE pf_reg = ".$idPF;
            $statement = $this->pdo->query($sql);

        }
    } 
?>