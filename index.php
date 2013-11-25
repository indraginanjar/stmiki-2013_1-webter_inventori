<?php

$BaseUrl = substr($_SERVER['PHP_SELF']
		, 0
		, strpos($_SERVER['PHP_SELF'], 'index.php')
		);

require_once dirname(__FILE__) . '/controllers/MainController.php';

$controller = new MainController();
$controller->Run();
?>
