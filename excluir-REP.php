<?php

require "src/bd-connect.php";
require "src/model/rep.php";
require "src/model/progFin.php";
require "src/repository/repRepository.php";
require "src/repository/progFinRepository.php";

$repRepository = new RepRepository($pdo);
$repRepository->deleteFromID($_POST['idRep'],$_POST['idDisp']);

header("Location: admin.php");