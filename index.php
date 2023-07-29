<?php

    require "src/bd-connect.php";

    

    $progFin = [
        [
            'numero' => "2023PF023476",
            'valorTotal' => "30.587,12",
            'valorRestante' => "26.422,01",
            'data' => "21/06/2023",
            'conta' => "TDCNAB240",
            'UG' => "3ºRC Mec"
        ],
        [
            'numero' => "2023PF023223",
            'valorTotal' => "4.800,10",
            'valorRestante' => "1.212,86",
            'data' => "18/06/2023",
            'conta' => "TDINC2222",
            'UG' => "3ºBLog"
        ],
        [
            'numero' => "2023PF020123",
            'valorTotal' => "10.117,66",
            'valorRestante' => "200,01",
            'data' => "03/07/2023",
            'conta' => "TDCNAB240",
            'UG' => "25ºGAC"
        ]
    ];
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
                Valor Total: R$ <?php echo $pf['valorTotal']?>
            </valor-box>
            <valor-box>
               Valor Restante: R$ <?php echo $pf['valorRestante']?>
            </valor-box>
        </div>
        <div>
            <p class="subinfo">
                Data: <?php echo $pf['data']?>
            </p>
        </div>
        <div>
            <p class="subinfo">
                CC: <?php echo $pf['conta']?> - <?php echo $pf['UG']?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>
</body>