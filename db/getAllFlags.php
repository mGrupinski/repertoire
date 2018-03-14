<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

$a = \repertoire\Main::getDatenbank()->getAllFlags();
$b = array();
foreach($a as $id => $flagarray) {
    $b[$id] = json_encode($flagarray);
}
echo json_encode($b);
