<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";
    require "src/repository/progFinRepository.php";

    $progFinRepository = new progFinRepository($pdo);
    $dadosPF = $progFinRepository->openPF();
    $dadosClosedPF = $progFinRepository->closedPF();

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
            <a href="main-page.php">Início</a>
            <a class="active" href="index.php">Situação por PF</a>
            <a href="insert.php">Inserir</a>
            <a href="">Gerar PDF</a>
        </div>
    </div>
</header>
<body>
    <h1 style="text-align: center;color:white;">Programações Financeiras em ABERTO</h1>
    <?php foreach($dadosPF as $pf): ?>
    <div class="box">
        <div>
            <PFnumber><?php echo $pf->getNumber()?></PFnumber>
        </div>
        <div>
            <valor-box>
                Valor Total: <?php echo $pf->getFormatedValue($pf->getValue())?>
            </valor-box>
            <valor-box>
               Valor Restante: <?php echo $pf->getFormatedValue($pf->getDisp())?>
            </valor-box>
        </div>
        <div>
            <p class="subinfo">
                Data: <?php echo $pf->getFormatedDate($pf->getDate())?>
            </p>
        </div>
        <div>
            <p class="subinfo">
                CC: <?php echo $pf->getConta()?> - <?php echo $pf->getResp()?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>


    <h1 style="text-align: center;color:white;">Programações Financeiras FECHADAS</h1>
    <?php foreach($dadosClosedPF as $pf): ?>
    <div class="box">
        <div>
            <PFnumber><?php echo $pf->getNumber()?></PFnumber>
        </div>
        <div>
            <valor-box>
                Valor Total: <?php echo $pf->getFormatedValue($pf->getValue())?>
            </valor-box>
            <valor-box>
               Valor Restante: <?php echo $pf->getFormatedValue($pf->getDisp())?>
            </valor-box>
        </div>
        <div>
            <p class="subinfo">
                Data: <?php echo $pf->getFormatedDate($pf->getDate())?>
            </p>
        </div>
        <div>
            <p class="subinfo">
                CC: <?php echo $pf->getConta()?> - <?php echo $pf->getResp()?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>
</body>