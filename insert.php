<?php

    require "src/bd-connect.php";

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8"/>
</head>
<header>
    <div class="head_logo" style="text-align: center;">
        <img src="img/logo_full.png" width="24%" style="position: relative; top: 5px; scale: 95%;" >
    </div>
    <div style="background-color:#1D211C; scale:105%">
        <div class="topnav">
            <a href="index.php">Início</a>
            <a class="active" href="insert.php">Inserir</a>
            <a href="">Gerar PDF</a>
        </div>
    </div>
</header>
<body>
    <h1 style="text-align: center;color:white;">INSERÇÃO DE DADOS</h1>
    <h2>crédito ou débito</h2>
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
            echo '
                <div class="box-insert" style="background-color: #92A299">
                    <form method="post">
                        <label2>Número da PF:</label2>
                        <input type="number" name="number" />
                        <label2>Conta:</label2>
                        <select style="margin-right: 1.4vw;" name="conta">
                            <option value="">ESCOLHA UMA CONTA</option>
                            <option value="TDCNAB240">TDCNAB240</option>
                            <option value="TDINC2222">TDINC2222</option>
                            <option value="160063">160063</option>
                            <option value="REP">Repasse</option>
                        </select>
                        <label2>Data:</label2>
                        <input type="date" name="date" />
                        <label2>UG/Credor:</label2>
                        <input type="text" name="resp" />
                        <label2>Valor:</label2>
                        <input type="number" min="1" step="any" name="value"><br>
                        <label2 style="align-content:left">Observação:</label2><br>
                        <textarea type="text" id="textbox" name="obs" placeholder="insira aqui uma observação."></textarea><br>
                        <input type="submit" value="CADASTRAR" />
                    </form>
                </div>
            ';
            
            // $sql = "INSERT INTO con_PF ()
            // VALUES ()";
        }
        ?>
    </div>
</body>