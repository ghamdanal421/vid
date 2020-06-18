<?php

	$dsn = 'mysql:host=localhost;dbname=ibranime';
	$user = 'root';
	$pass = '';

//	$dsn = 'mysql:host=localhost;dbname=u278675151_shop';
//	$user = 'u278675151_ghamdan';
//	$pass = 'q3zG6/XN';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try {
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e) {
		?>
		 <h1 style="
    text-align: center;
    color: #E91E63;
    padding: 30px;
">فشل الاتصال بقاعدة البيانات </h1>
	<code style="
    font-size: 20px;
"> <b style="
    color: #f10;
    font-size: 29px;
">ERROR: </b>
		<?=$e->getMessage()?>
		</code>
		<?php
		exit();
	}



// By Ghamdan AL-Seydy 

$pricerate = 10;


	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" ;
	$actual_link .= '/vid/';