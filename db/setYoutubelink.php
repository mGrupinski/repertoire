<?php

namespace repertoire\php;

require_once $_SERVER['DOCUMENT_ROOT'] . '/netbeans/repertoire/Main.php';

\repertoire\Main::getDatenbank()->setYoutubelink($_POST['id'], $_POST['link']);
