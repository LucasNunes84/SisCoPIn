
<?php

  require "src/bd-connect.php";
  require "src/model/pgto.php";
  require "src/model/progFin.php";
  require "src/repository/pgtoRepository.php";
  require "src/repository/progFinRepository.php";

  $progFinRepository = new progFinRepository($pdo);
  $dadosPF = $progFinRepository->getFromIDPF($_POST['id']);

  $pgtoRepository = new pgtoRepository($pdo);
  $dadosPgto = $pgtoRepository->getPgtoFromPFID($_POST['id']);

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8"/>
    <script>
      function clicked(e)
      {
          if(!confirm('Você está prestes a apagar para sempre um pagamento lançado! Você tem certeza?')) {
              e.preventDefault();
          }
      }
    </script>
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
      <td>
        <form action="insert-PGTO.php" method="post">
          <input type="hidden" name="number" value="<?= $pf->getNumber()?>">
          <input type="submit" class="botao-add" value="VINC PGTO">
        </form>
      </td>
    <?php endforeach; ?>

    <h1 style="text-align: center; color: white;margin-bottom:-4vh">Pagamentos Vinculados a PF</h1>

    <section class="container-table">
      <table>
        <thead>
          <tr>
            <th>Número do Doc Hab</th>
            <th>Credor</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dadosPgto as $Pgto): ?>
            <tr>
              <td><?= $Pgto->getDocHab() ?></td>
              <td><?= $Pgto->getCred() ?></td>
              <td><?= $Pgto->getFormatedValue($Pgto->getValue()) ?></td>
              <td><?= $Pgto->getFormatedDate($Pgto->getDate()) ?></td>
              <td>
                <form action="excluir-PGTO.php" method="post">
                  <input type="hidden" name="id" value="<?= $Pgto->getId() ?>">
                  <input type="submit" onclick="clicked(event)" class="botao-excluir" value="Excluir">
                </form>
              </td>
            </tr>
        <?php endforeach; ?>
      </table>

</body>