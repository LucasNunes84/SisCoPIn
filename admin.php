<?php

    require "src/bd-connect.php";
    require "src/model/progFin.php";
    require "src/repository/progFinRepository.php";

    $progFinRepository = new progFinRepository($pdo);
    $dadosPF = $progFinRepository->allPF();

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
<h2>Lista de Produtos</h2>

<section class="container-table">
  <table>
    <thead>
      <tr>
        <th>Produto</th>
        <th>Tipo</th>
        <th>Descricão</th>
        <th>Valor</th>
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
          <td><a class="botao-editar" href="editar-produto.html">Editar</a></td>
          <td>
            <form action="excluir-produto.php" method="post">
                <input type="hidden" name="id" value="<?= $PF->getId() ?>">
              <input type="submit" class="botao-excluir" value="Excluir">
            </form>
          </td>
        </tr>
    <?php endforeach; ?>
</body>