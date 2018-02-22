<?php

namespace repertoire\php;
require_once $_SERVER['DOCUMENT_ROOT'].'/netbeans/repertoire/Main.php';

$id = \repertoire\Main::getDatenbank()->addSong($_POST['interpret'], $_POST['songtitel']);

echo $id.' erfolgreich eingetragen!';