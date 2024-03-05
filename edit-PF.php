
<?php

  require "src/bd-connect.php";
  require "src/model/pgto.php";
  require "src/model/progFin.php";
  require "src/model/rep.php";
  require "src/model/rev.php";
  require "src/repository/pgtoRepository.php";
  require "src/repository/progFinRepository.php";
  require "src/repository/repRepository.php";
  require "src/repository/revRepository.php";

  $progFinRepository = new progFinRepository($pdo);
  $dadosPF = $progFinRepository->getFromIDPF($_POST['id']);

  $pgtoRepository = new pgtoRepository($pdo);
  $dadosPgto = $pgtoRepository->getPgtoFromPFID($_POST['id']);

  $repRepository = new repRepository($pdo);
  $dadosRep = $repRepository->getRepFromPFID($_POST['id']);

  $revRepository = new revRepository($pdo);
  $dadosRev = $revRepository->getRevFromPFID($_POST['id']);

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
            <a href="all-PGTO.php">Lançamentos</a>
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
                  <input type="hidden" name="idPgto" value="<?= $Pgto->getId() ?>">
                  <?php foreach ($dadosPF as $pf): ?>
                    <input type="hidden" name="idDisp" value="<?= $pf->getId() ?>">
                  <?php endforeach; ?>
                  <input type="submit" onclick="clicked(event)" class="botao-excluir" value="Excluir">
                </form>
              </td>
            </tr>
        <?php endforeach; ?>
      </table>

      <h1 style="text-align: center; color: white;margin-bottom:-4vh">Repasses Vinculados a PF</h1>

    <section class="container-table">
      <table>
        <thead>
          <tr>
            <th>Número do Doc Hab</th>
            <th>Destino</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dadosRep as $rep): ?>
            <tr>
              <td><?= $rep->getDocHab() ?></td>
              <td><?= $rep->getDest() ?></td>
              <td><?= $rep->getFormatedValue($rep->getValue()) ?></td>
              <td><?= $rep->getFormatedDate($rep->getDate()) ?></td>
              <td>
                <form action="excluir-REP.php" method="post">
                  <input type="hidden" name="idRep" value="<?= $rep->getId() ?>">
                  <?php foreach ($dadosPF as $pf): ?>
                    <input type="hidden" name="idDisp" value="<?= $pf->getId() ?>">
                  <?php endforeach; ?>
                    <input type="submit" onclick="clicked(event)" class="botao-excluir" value="Excluir">
                </form>
              </td>
            </tr>
        <?php endforeach; ?>
      </table>

      <h1 style="text-align: center; color: white;margin-bottom:-4vh">Reversões Vinculadas a PF</h1>

      <section class="container-table">
      <table>
        <thead>
          <tr>
            <th>Número GR</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dadosRev as $rev): ?>
            <tr>
              <td><?= $rev->getGR() ?></td>
              <td><?= $rev->getFormatedValue($rev->getValue()) ?></td>
              <td><?= $rev->getFormatedDate($rev->getDate()) ?></td>
              <td>
                <form action="excluir-REV.php" method="post">
                  <input type="hidden" name="idRev" value="<?= $rev->getId() ?>">
                  <?php foreach ($dadosPF as $pf): ?>
                    <input type="hidden" name="idDisp" value="<?= $pf->getId() ?>">
                  <?php endforeach; ?>
                    <input type="submit" onclick="clicked(event)" class="botao-excluir" value="Excluir">
                </form>
              </td>
            </tr>
        <?php endforeach; ?>
      </table>
</body>