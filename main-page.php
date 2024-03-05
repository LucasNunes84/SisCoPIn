<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";
    require "src/repository/progFinRepository.php";
    require "src/model/conta.php";

    $progFinRepository = new progFinRepository($pdo);
    $allContas = $progFinRepository->allContasDB();
    foreach($allContas as $contas){
        $dadosDashboard[$contas['conta']] = $progFinRepository->contaTotalValue($contas['conta']);
    }

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
            <a class="active" href="main-page.php">Início</a>
            <a href="index.php">Situação por PF</a>
            <a href="all-PGTO.php">Lançamentos</a>
            <a href="insert.php">Inserir</a>
            <a href="">Gerar PDF</a>
        </div>
    </div>
</header>
<body>
    <h1 style="text-align: center;color:white;">VALORES POR CONTA</h1>
    <?php foreach($dadosDashboard as $dash): ?>
    <div class="box">
        <div style="margin-bottom: 6vh;">
            <PFnumber><?php echo $dash->getConta()?></PFnumber>
        </div>
        <div style="scale: 160%">
            <valor-box>
                Em tela: <?php echo $dash->getFormatedValue($dash->getRestante())?>
            </valor-box>
        </div>
    </div>
    <?php endforeach; ?>
</body>