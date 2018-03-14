<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

$rs = \repertoire\Main::getDatenbank()->getInterpret($_POST['id']);
$rs .= " - " . \repertoire\Main::getDatenbank()->getSongtitel($_POST['id']);


echo $rs;