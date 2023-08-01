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
                        <select name="tipo">
                            <option value="">ESCOLHA UMA CONTA</option>
                            <option value="TDCNAB240">TDCNAB240</option>
                            <option value="TDINC2222">TDINC2222</option>
                            <option value="160063">160063</option>
                            <option value="REP">Repasse</option>
                        </select>
                    </form>
                </div>
            ';
        }
        ?>
    </div>
</body>