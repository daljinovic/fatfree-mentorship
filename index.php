<?php 

$f3=require('src/fatfree-master/lib/base.php');

$f3->config('app/config/config.ini');
$f3->config('app/config/routes.ini');

$f3->run();
