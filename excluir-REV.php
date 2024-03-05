<?php

require "src/bd-connect.php";
require "src/model/rev.php";
require "src/model/progFin.php";
require "src/repository/revRepository.php";
require "src/repository/progFinRepository.php";

$revRepository = new RevRepository($pdo);
$revRepository->deleteFromID($_POST['idRev'],$_POST['idDisp']);

header("Location: admin.php");