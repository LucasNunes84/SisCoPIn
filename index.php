<?php

    require "src/bd-connect.php";

    $sql1 = "SELECT 
                con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND disp_PF.disp>0"
            ;

    $statement = $pdo -> query($sql1);
    $progFin = $statement -> fetchAll(PDO::FETCH_ASSOC);

    $sql1 = "SELECT 
                con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg AND disp_PF.disp=0"
            ;
    $statement = $pdo -> query($sql1);
    $closedProgFin = $statement -> fetchAll(PDO::FETCH_ASSOC);

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
    <?php foreach($progFin as $pf): ?>
    <div class="box">
        <div>
            <PFnumber><?php echo $pf['numero']?></PFnumber>
        </div>
        <div>
            <valor-box>
                Valor Total: R$ <?php echo str_replace('#','.', str_replace('.',',', str_replace(',', '#', number_format($pf['valor'], 2))))?>
            </valor-box>
            <valor-box>
               Valor Restante: R$ <?php echo str_replace('#','.', str_replace('.',',', str_replace(',', '#', number_format($pf['disp'], 2))))?>
            </valor-box>
        </div>
        <div>
            <p class="subinfo">
                Data: <?php echo date("d/m/Y", strtotime($pf['dt_siafi']))?>
            </p>
        </div>
        <div>
            <p class="subinfo">
                CC: <?php echo $pf['conta']?> - <?php echo $pf['resp']?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>


    <h1 style="text-align: center;color:white;">Programações Financeiras FECHADAS</h1>
    <?php foreach($closedProgFin as $pf): ?>
    <div class="box">
        <div>
            <PFnumber><?php echo $pf['numero']?></PFnumber>
        </div>
        <div>
            <valor-box>
                Valor Total: R$ <?php echo str_replace('#','.', str_replace('.',',', str_replace(',', '#', number_format($pf['valor'], 2))))?>
            </valor-box>
            <valor-box>
               Valor Restante: R$ <?php echo str_replace('#','.', str_replace('.',',', str_replace(',', '#', number_format($pf['disp'], 2))))?>
            </valor-box>
        </div>
        <div>
            <p class="subinfo">
                Data: <?php echo date("d/m/Y", strtotime($pf['dt_siafi']))?>
            </p>
        </div>
        <div>
            <p class="subinfo">
                CC: <?php echo $pf['conta']?> - <?php echo $pf['resp']?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>
</body>