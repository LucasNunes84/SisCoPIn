<?php
    class pgtoRepository{
            
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }


        public function salvar(pgto $pgto){
            $sql = "SELECT 
                        con_PF.id_reg, disp_PF.id_disp, disp_PF.disp 
                    FROM 
                        con_PF, disp_PF 
                    WHERE 
                        con_PF.numero='". $pgto->getVincPF() ."' AND con_PF.id_reg=disp_PF.pf_reg"
                    ; 
            $statement = $this->pdo->query($sql);
            $pf = $statement -> fetch(PDO::FETCH_ASSOC);
            if($pf['disp']>=$pgto->getValue()){
                $sql = "INSERT INTO 
                            pgto_PF (id_pgto_pf, valor_pgto, dt_pgto, credor, doc_hab) 
                        VALUES 
                            (?,?,?,?,?)"
                        ;

                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(1, $pf['id_disp']);
                $statement->bindValue(2, $pgto->getValue());
                $statement->bindValue(3, $pgto->getDate());
                $statement->bindValue(4, $pgto->getCred());
                $statement->bindValue(5, $pgto->getYearDate($pgto->getDate()).'DT'.sprintf('%06d', $pgto->getDocHab()));
                $statement->execute();

                $sql = "UPDATE 
                            disp_pf 
                        SET 
                            disp=".($pf['disp']-$pgto->Getvalue())." 
                        WHERE 
                            (id_disp= '".$pf['id_disp']."');"
                        ;
                $statement = $this->pdo->query($sql);
            }
        }

        public function searchPgtoFromPF(int $idPF){
            $sql = "SELECT 
                        pgto_PF.id_reg, pgto_PF.id_pgto_pf, pgto_PF.valor_pgto, pgto_PF.dt_pgto, pgto_PF.credor, pgto_PF.doc_hab 
                    FROM 
                        pgto_PF 
                    WHERE 
                        id_pgto_pf='".$idPF
                    ;

            $statement = $this->pdo -> query($sql);
            $selectPgto = $statement -> fetchAll(PDO::FETCH_ASSOC);
            
            $dadosPgto = array_map(function ($pgto){
                return new pgto(
                    $pgto['id_reg'],
                    $pgto['id_pgto_pf'],
                    $pgto['valor_pgto'],
                    $pgto['dt_pgto'],
                    $pgto['cred'],
                    $pgto['doc_hab']
                );
            }, $selectPgto);

            return $dadosPgto;
        }

        public function deleteFromPF(int $id)
        {
            //busca o id da PF disponivel
            $sql = "SELECT id_disp FROM disp_PF WHERE pf_reg = ".$id;
            //armazena no result
            $statement = $this->pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //deleta onde possui o resultado
            $sql = "DELETE FROM pgto_pf WHERE id_pgto_pf = ".$result['id_disp'];
            $statement = $this->pdo->query($sql);
            //deleta o id da PF disponivel
            $sql = "DELETE FROM disp_PF WHERE pf_reg = ".$id;
            $statement = $this->pdo->query($sql);

        }
    } 
?>