<?php

namespace repertoire;

include 'main.php';

error_reporting(E_ALL);

Main::init();
echo Main::getMainContent();
?>