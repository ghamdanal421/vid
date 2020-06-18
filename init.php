<?php

	// Error Reporting

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	include 'admin/connect.php';
date_default_timezone_set('Asia/Aden');

	$sessionUser = '';

	
	if (isset($_SESSION['user'])) {
		$sessionUser = $_SESSION['user'];
	}

	// Routes

	$tpl 	= 'includes/templates/'; // Template Directory
	$lang 	= 'includes/languages/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= $actual_link.'layout/css/'; // Css Directory
	$js 	= $actual_link. 'layout/js/'; // Js Directory
	$image 	= $actual_link.'layout/images/'; // images Directory

	// Include The Important Files

	include $func . 'functions.php';
	include $lang . 'english.php';
	include $tpl . 'header.php';
	

	