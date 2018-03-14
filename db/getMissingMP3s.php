<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

$a = \repertoire\Main::getDatenbank()->getMissingMP3s();
echo json_encode($a);
