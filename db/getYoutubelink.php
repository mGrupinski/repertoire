<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

$rs = \repertoire\Main::getDatenbank()->getYoutubelink($_POST['id']);
$rs = str_replace("watch?v=", "embed/", $rs);
echo $rs;
