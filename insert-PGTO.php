<?php

    require "src/bd-connect.php";
    require "src/model/pgto.php";
    require "src/model/progFin.php";
    require "src/repository/pgtoRepository.php";
    require "src/repository/progFinRepository.php";

    $progFinRepository = new progFinRepository($pdo);
    $dadosPF = $progFinRepository->openPF();

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
        ?>
        <div class="box-insert" style="background-color: #92A299">
            <form method="post">
                <label2>PF Aberta:</label2>
                <select style="margin-right: 1.4vw;" name="vincPF">
                <?php foreach($dadosPF as $pf): ?>
                    <option value="<?php echo $pf->getNumber()?>"><?php echo $pf->getNumber()?></option>
                <?php endforeach; ?>
                </select>
                <label2>Data do pagamento:</label2>
                <input type="date" name="dt_pgto" />
                <label2>Credor:</label2>
                <input type="text" name="cred" />
                <label2>Valor:</label2>
                <input type="number" min="1" step="any" name="valor"><br>
                <label2 style="align-content:left">Observação:</label2><br>
                <textarea type="text" id="textbox" name="obs" placeholder="insira aqui uma observação."></textarea><br>
                <input type="submit" name="cadastro" />
            </form>
            <?php
                if (isset($_POST['cadastro'])){
                    $pgto = new pgto(null,
                        $_POST['vincPF'],
                        $_POST['valor'],
                        $_POST['dt_pgto'],
                        $_POST['cred']
                    );
            
                    $pgtoRepository = new pgtoRepository($pdo);
                    $pgtoRepository->salvar($pgto);
                }       
            ?>
        </div>
    </div>
</body>