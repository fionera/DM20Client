<?php

include_once 'vendor/autoload.php';


$loop = React\EventLoop\Factory::create();

$kernel = new \DM20Client\Kernel($loop);

$loop->run();