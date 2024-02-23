<?php

require "src/bd-connect.php";
require "src/model/pgto.php";
require "src/model/progFin.php";
require "src/repository/pgtoRepository.php";
require "src/repository/progFinRepository.php";

$pgtoRepository = new PgtoRepository($pdo);
$pgtoRepository->deleteFromID($_POST['idPgto'],$_POST['idDisp']);

header("Location: admin.php");