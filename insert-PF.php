<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";
    require "src/repository/progFinRepository.php";

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
    <h1 style="text-align: center;color:white;">PROGRAMAÇÃO FINANCEIRA</h1>
    <h2>crédito</h2>
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
        ?>
        <div class="box-insert" style="background-color: #92A299">
            <form method="post">
                <label2>Número da PF:</label2>
                <input type="number" name="numero" />
                <label2>Conta:</label2>
                <select style="margin-right: 1.4vw;" name="conta">
                    <option value="">ESCOLHA UMA CONTA</option>
                    <option value="TDCNAB240">TDCNAB240</option>
                    <option value="TDINC2222">TDINC2222</option>
                    <option value="160063">160063</option>
                    <option value="TDBLOQ001">TDBLOQ001</option>
                    <option value="TDBLOQ033">TDBLOQ033</option>
                    <option value="TDBLOQ041">TDBLOQ041</option>
                    <option value="TDBLOQ104">TDBLOQ104</option>
                    <option value="TDBLOQ237">TDBLOQ237</option>
                    <option value="TDBLOQ341">TDBLOQ341</option>
                    <option value="TDNREL104">TDNREL104</option>
                    <option value="TDREVMILA">TDREVMILA</option>
                    <option value="TDDEVMIPE">TDDEVMIPE</option>
                    <option value="TDDEVMIPE">FAKENEWS</option>
                </select>
                <label2>Data:</label2>
                <input type="date" name="dt_siafi" />
                <label2>UG/Credor:</label2>
                <input type="text" name="resp" />
                <label2>Valor:</label2>
                <input type="text" name="valor" id="valor" onkeyup="formatCurrency(this)" placeholder="Digite o valor"><br>
                <label2 style="align-content:left">Observação:</label2><br>
                <textarea type="text" id="textbox" name="obs" placeholder="insira aqui uma observação."></textarea><br>
                <input type="submit" name="cadastro" />
            </form>
            <?php
                if (isset($_POST['cadastro'])){
                    $progFin = new progFin(null,
                        $_POST['numero'],
                        $_POST['valor'],
                        $_POST['dt_siafi'],
                        $_POST['conta'],
                        $_POST['resp'],
                        $_POST['valor']
                    );

                    if($progFin->isFull()){
                        $progFinRepository = new progFinRepository($pdo);
                        $progFinRepository->salvar($progFin);
                    }else{
                        echo
                        '<script>alert("Há algum erro para inserção da PF, favor verificar todos os campos!")</script>';
                    }
                }       
            ?>
        </div>
    </div>
</body>