<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

\repertoire\Main::getDatenbank()->toggleFlag($_POST['id'], $_POST['type']);
