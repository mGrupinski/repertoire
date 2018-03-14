<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

$rs = \repertoire\Main::getDatenbank()->removeFilter();
