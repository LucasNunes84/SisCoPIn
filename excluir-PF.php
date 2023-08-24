<?php

require "src/bd-connect.php";
require "src/model/pgto.php";
require "src/model/progFin.php";
require "src/repository/pgtoRepository.php";
require "src/repository/progFinRepository.php";

$progFinRepository = new ProgFinRepository($pdo);
$progFinRepository->delete($_POST['id']);

header("Location: admin.php");