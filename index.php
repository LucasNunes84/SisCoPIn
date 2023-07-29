<?php

    require "src/bd-connect.php";

    $sql1 = "SELECT 
                con_PF.numero, con_PF.valor, con_PF.dt_siafi, con_PF.conta, con_PF.resp, disp_PF.disp
            FROM 
                con_PF, disp_PF
            WHERE 
                con_PF.id_reg=disp_PF.pf_reg"
            ;

    $statement = $pdo -> query($sql1);
    $progFin = $statement -> fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8"/>
</head>
<header>
    <div style="text-align: center;">
        <img src="img/logo_full.png" width="24%" style="position: relative; top: 5px; scale: 95%;" >
    </div>
</header>
<body>
    <h1 style="text-align: center;color:white;">Programações Financeiras em Aberto</h1>
    <?php foreach($progFin as $pf): ?>
    <div class="box">
        <div>
            <PFnumber><?php echo $pf['numero']?></PFnumber>
        </div>
        <div>
            <valor-box>
                Valor Total: R$ <?php echo $pf['valor']?>
            </valor-box>
            <valor-box>
               Valor Restante: R$ <?php echo $pf['disp']?>
            </valor-box>
        </div>
        <div>
            <p class="subinfo">
                Data: <?php echo $pf['dt_siafi']?>
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