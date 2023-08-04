<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";

    $sql1 = "SELECT 
                con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND disp_PF.disp>0"
            ;

    $statement = $pdo -> query($sql1);
    $progFin = $statement -> fetchAll(PDO::FETCH_ASSOC);
    
    $dadosPF = array_map(function ($PF){
        return new progFin(
            $PF['numero'],
            $PF['valor'],
            $PF['dt_siafi'],
            $PF['conta'],
            $PF['resp'],
            $PF['disp']
        );
    }, $progFin);

    $sql1 = "SELECT 
                con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND disp_PF.disp=0"
            ;
    $statement = $pdo -> query($sql1);
    $closedProgFin = $statement -> fetchAll(PDO::FETCH_ASSOC);

    $dadosClosedPF = array_map(function ($PF){
        return new progFin(
            $PF['numero'],
            $PF['valor'],
            $PF['dt_siafi'],
            $PF['conta'],
            $PF['resp'],
            $PF['disp']
        );
    }, $closedProgFin);

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
            <a class="active" href="index.php">Início</a>
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
                Valor Total: R$ <?php echo $pf->getFormatedValue($pf->getValue())?>
            </valor-box>
            <valor-box>
               Valor Restante: R$ <?php echo $pf->getFormatedValue($pf->getDisp())?>
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
                Valor Total: R$ <?php echo $pf->getFormatedValue($pf->getValue())?>
            </valor-box>
            <valor-box>
               Valor Restante: R$ <?php echo $pf->getFormatedValue($pf->getDisp())?>
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