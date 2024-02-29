<?php

    require "src/bd-connect.php";
    require "src/model/rep.php";
    require "src/model/progFin.php";
    require "src/repository/repRepository.php";
    require "src/repository/progFinRepository.php";

    $progFinRepository = new progFinRepository($pdo);
    $dadosPF = $progFinRepository->openPF();

?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8"/>
    <script>
    function formatCurrency(input) {
        // Remove todos os caracteres não numéricos
        var value = input.value.replace(/\D/g, '');

        // Adiciona a vírgula para separar os centavos
        if (value.length > 2) {
            value = value.substring(0, value.length - 2) + '.' + value.substring(value.length - 2);
        }

        // Atualiza o valor no input
        input.value = value;
    }
    </script>
</head>
<header>
    <div class="head_logo" style="text-align: center;">
        <img src="img/logo_full.png" width="24%" style="position: relative; top: 5px; scale: 95%;" >
    </div>
    <div style="background-color:#1D211C; scale:105%">
        <div class="topnav">
            <a href="main-page.php">Início</a>
            <a href="index.php">Situação por PF</a>
            <a class="active" href="insert.php">Inserir</a>
            <a href="">Gerar PDF</a>
        </div>
    </div>
</header>
<body>
    <h1 style="text-align: center;color:white;">PAGAMENTO</h1>
    <h2>débito</h2>
    <div class="box-insert">
        <form method="post">
            <label >TIPO DO DADO INSERIDO:</label>
            <select name="tipo">
                <option value="">-- ESCOLHA UM TIPO --</option>
                <option value="PF">Programação Financeira</option>
                <option value="PGTO">Pagamento</option>
                <option value="REV">Reversão</option>
                <option value="REP">Repasse</option>
            </select>
            <input type="submit" value="SELECIONAR" />
        </form>
        <?php
        $selectOption = $_POST['tipo'] ?? "nenhum";
        session_start();
        if($selectOption == 'PF' ){
            header("Location: insert-PF.php");
        }
        if($selectOption == 'PGTO' ){
            header("Location: insert-PGTO.php");
        }
        if($selectOption == 'REP' ){
            header("Location: insert-REP.php");
        }
        if($selectOption == 'REV' ){
            header("Location: insert-REV.php");
        }
        ?>
        <div class="box-insert" style="background-color: #92A299">
            <form method="post">
                <label2>PF Aberta:</label2>
                <select style="margin-right: 1.4vw;" name="vincPF">
                <?php foreach($dadosPF as $pf){
                    echo '<option value="'.$pf->getNumber().'" '.(($pf->getNumber() == $_POST['number']) ? 'selected' : '').'>'.$pf->getNumber().'</option>';
                }?>
                </select>
                <label2>Data do repasse:</label2>
                <input type="date" name="dt_rep" />
                <label2>Destino:</label2>
                <input type="text" name="destino" />
                <label2>Valor:</label2>
                <input type="text" name="valor" id="valor" onkeyup="formatCurrency(this)" placeholder="Digite o valor">
                <label2>Numero Doc Hab:</label2>
                <input type="text" name="doc_hab" />
                <br>
                <label2 style="align-content:left">Observação:</label2><br>
                <textarea type="text" id="textbox" name="obs" placeholder="insira aqui uma observação."></textarea><br>
                <input type="submit" name="cadastro" />
            </form>
            <?php
                if (isset($_POST['cadastro'])){
                    $rep = new rep(null,
                        $_POST['vincPF'],
                        $_POST['dt_rep'],
                        $_POST['doc_hab'],
                        $_POST['destino'],
                        $_POST['valor']
                    );

                    if($rep->isFull()){
                        $repRepository = new repRepository($pdo);
                        $repRepository->salvar($rep);
                    }else{
                        echo
                        '<script>alert("Há algum erro para inserção do pagamento, favor verificar todos os campos!")</script>';
                    }                
                }     
            ?>
        </div>
    </div>
</body>