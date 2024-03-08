
<?php
    class revRepository{
            
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }


        public function salvar(rev $rev){
            $sql = "SELECT 
                        con_pf.id_reg, disp_pf.id_disp, disp_pf.disp 
                    FROM 
                        con_pf, disp_pf 
                    WHERE 
                        con_pf.numero='". $rev->getVincPF() ."' AND con_pf.id_reg=disp_pf.pf_reg"
                    ; 
            $statement = $this->pdo->query($sql);
            $pf = $statement -> fetch(PDO::FETCH_ASSOC);
            if($pf['disp']>=$rev->getValue()){
                $sql = "INSERT INTO 
                            rev_pf (pf_reg, dt_gr, gr, valor) 
                        VALUES 
                            (?,?,?,?)"
                        ;

                $statement = $this->pdo->prepare($sql);
                $statement->bindValue(1, $pf['id_disp']);
                $statement->bindValue(2, $rev->getDate());
                $statement->bindValue(3, $rev->getYearDate($rev->getDate()).'GR'.sprintf('%06d', $rev->getGR()));
                $statement->bindValue(4, $rev->getValue());
                $statement->execute();

                $sql = "UPDATE 
                            disp_pf 
                        SET 
                            disp=".($pf['disp']-$rev->Getvalue())." 
                        WHERE 
                            (id_disp= '".$pf['id_disp']."');"
                        ;
                $statement = $this->pdo->query($sql);
            }else{
                throw new Exception('VALOR MAIOR DO QUE DISPONÍVEL NA PF');
            }
        }

        public function searchrevFromPF(int $idPF){
            $sql = "SELECT 
                        rev_pf.id_reg, rev_pf.pf_reg , rev_pf.dt_gr, rev_pf.gr, rev_pf.valor
                    FROM 
                        rev_pf 
                    WHERE 
                        id_rev_pf='".$idPF
                    ;

            $statement = $this->pdo -> query($sql);
            $selectrev = $statement -> fetchAll(PDO::FETCH_ASSOC);
            
            $dadosrev = array_map(function ($rev){
                return new rev(
                    $rev['id_reg'],
                    $rev['pf_reg'],
                    $rev['dt_gr'],
                    $rev['gr'],
                    $rev['valor']
                );
            }, $selectrev);

            return $dadosrev;
        }

        public function getrevFromPFID(int $id){
            //busca o id da PF disponivel
            $sql = "SELECT id_disp FROM disp_PF WHERE pf_reg = ".$id;
            //armazena no result
            $statement = $this->pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $sql = "SELECT 
                        rev_pf.id_reg, rev_pf.pf_reg, rev_pf.dt_gr, rev_pf.gr, rev_pf.valor
                    FROM 
                        rev_pf 
                    WHERE 
                        validade='S' AND pf_reg=".$result['id_disp']
                    ;

            $statement = $this->pdo -> query($sql);
            $selectrev = $statement -> fetchAll(PDO::FETCH_ASSOC);

            $dadosrev = array_map(function ($rev){
                return new rev(
                    $rev['id_reg'],
                    $rev['pf_reg'],
                    $rev['dt_gr'],
                    $rev['gr'],
                    $rev['valor']
                );
            }, $selectrev);

            return $dadosrev;
        }

        public function deleteFromPF(int $id)
        {
            //busca o id da PF disponivel
            $sql = "SELECT id_disp FROM disp_PF WHERE pf_reg = ".$id;
            //armazena no result
            $statement = $this->pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //deleta onde possui o resultado
            $sql = "UPDATE rev_pf SET validade='N' WHERE pf_reg = ".$result['id_disp'];
            $statement = $this->pdo->query($sql);
            //deleta o id da PF disponivel
            $sql = "UPDATE disp_PF SET validade='N' WHERE pf_reg = ".$id;
            $statement = $this->pdo->query($sql);

        }
        public function deleteFromID(int $idrev, int $idPF)
        {
            //busca pega o valor do rev
            $sql = "SELECT valor FROM rev_pf WHERE id_reg = ".$idrev;
            //armazena no valorrev
            $statement = $this->pdo->query($sql);
            $valorrev = $statement->fetch(PDO::FETCH_ASSOC);
            //busca pega o valor disp na PF
            $sql = "SELECT disp FROM disp_PF WHERE id_disp = ".$idPF;
            //armazena no dispPF
            $statement = $this->pdo->query($sql);
            $dispPF = $statement->fetch(PDO::FETCH_ASSOC);
            //soma o valor do rev a ser deletado
            $dispPF['disp'] = $dispPF['disp'] + $valorrev['valor'];
            //deleta o rev selecionado
            $sql = "UPDATE rev_pf SET validade='N' WHERE id_reg = ".$idrev;
            $statement = $this->pdo->query($sql);
            //altera o valor disponivel da PF
            $sql = "UPDATE disp_PF SET disp=".$dispPF['disp']." WHERE id_disp = ".$idPF;
            $statement = $this->pdo->query($sql);

        }
    } 
?>