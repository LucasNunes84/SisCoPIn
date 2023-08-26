<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";
    require "src/repository/progFinRepository.php";

    $progFinRepository = new progFinRepository($pdo);
    $dadosPF = $progFinRepository->allActivePF();
    $dadosInactivePF = $progFinRepository->allInvalidPF();

?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8"/>
    <script>
      function clicked(e)
      {
          if(!confirm('Ao deletar uma PF serão DELETADOS TODOS OS PAGAMENTO vinculados a ela! Você tem certeza?')) {
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
    <h1 style="text-align: center; color: white;margin-bottom:-4vh">Lista de PF ativas</h1>

    <section class="container-table">
      <table>
        <thead>
          <tr>
            <th>Número</th>
            <th>Conta</th>
            <th>Valor Recebido</th>
            <th>Valor Restante</th>
            <th colspan="2">Ação</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dadosPF as $PF): ?>
            <tr>
              <td><?= $PF->getNumber() ?></td>
              <td><?= $PF->getConta() ?></td>
              <td><?= $PF->getFormatedValue($PF->getValue()) ?></td>
              <td><?= $PF->getFormatedValue($PF->getDisp()) ?></td>
              <td>
                <form action="edit-PF.php" method="post">
                  <input type="hidden" name="id" value="<?= $PF->getId() ?>">
                  <input type="submit" value="Editar">
                </form>
              </td>
              <td>
                <form action="excluir-PF.php" method="post">
                  <input type="hidden" name="id" value="<?= $PF->getId() ?>">
                  <input type="submit" onclick="clicked(event)" class="botao-excluir" value="Excluir">
                </form>
              </td>
            </tr>
        <?php endforeach; ?>
      </table>

    <h1 style="text-align: center; color: white;margin-bottom:-4vh">Lista de PF inativas</h1>

    <section class="container-table">
      <table>
        <thead>
          <tr>
            <th>Número</th>
            <th>Conta</th>
            <th>Valor Recebido</th>
            <th>Valor Restante</th>
            <th colspan="2">Ação</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dadosInactivePF as $PF): ?>
            <tr>
              <td><?= $PF->getNumber() ?></td>
              <td><?= $PF->getConta() ?></td>
              <td><?= $PF->getFormatedValue($PF->getValue()) ?></td>
              <td><?= $PF->getFormatedValue($PF->getDisp()) ?></td>
              <td><a class="botao-editar" href="edit-PF.php">Editar</a></td>
              <td>
                <form action="excluir-PF.php" method="post">
                  <input type="hidden" name="id" value="<?= $PF->getId() ?>">
                  <input type="submit" onclick="clicked(event)" class="botao-excluir" value="Excluir">
                </form>
              </td>
            </tr>
        <?php endforeach; ?>
        </table>

</body>