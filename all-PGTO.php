<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";
    require "src/repository/progFinRepository.php";
    require "src/model/pgto.php";
    require "src/repository/pgtoRepository.php";
  
    $pgtoRepository = new pgtoRepository($pdo);
    $dadosPgto = $pgtoRepository->allPGTO();

    $progFinRepository = new progFinRepository($pdo);
    $dadosPF = $progFinRepository->allActivePF();

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
            <a href="index.php">Situação por PF</a>
            <a class="active" href="all-PGTO.php">Lançamentos</a>
            <a href="insert.php">Inserir</a>
            <a href="">Gerar PDF</a>
        </div>
    </div>
</header>
<body>
    <h1 style="text-align: center;color:white;">Todos pagamentos realizados</h1>
    <a href="admin.php" class="button">GERENCIAR</a>
    <?php foreach(array_reverse($dadosPgto) as $pgto): ?>
            <div class="box">
                <div>
                    <PFnumber>
                        <?php foreach($progFinRepository->getFromIDPF($pgto->getVincPF()) as $pf):?>
                            <?php echo $pf->getNumber()?>
                        <?php endforeach; ?>
                    </PFnumber>
                </div>
                <div>
                    <valor-box>
                        Valor: <?php echo $pgto->getFormatedValue($pgto->getValue())?>
                    </valor-box>

                </div>
                <div>
                    <p class="subinfo">
                        Data: <?php echo $pgto->getFormatedDate($pgto->getDate())?>
                    </p>
                </div>
                <div>
                    <p class="subinfo">
                        Credor: <?php echo $pgto->getCred()?> - <?php echo $pgto->getDocHab()?>
                    </p>
                </div>
            </div>
    <?php endforeach; ?>
</body>