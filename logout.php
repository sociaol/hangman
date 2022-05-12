<!--- File: logout.php
 * Project: Project 2
 * File Created: 3/20/21
 * Author: Johnathan Nguyen
 -->
<!DOCTYPE html>
<html lang="en-us">

	<head>
		<meta charset="UTF-8">
		<title>Hangman</title>
		<link href="style.css" type="text/css" rel="stylesheet">
	</head>
	<?php
		require_once('util.php');

		session_start(); /* Starts the session */
		session_destroy(); /* Destroy started session */
		header("location:index.php");
		/* Redirect to login page */exit;
	?>


	<?php
		//footer function 
		footerFunction();
	?>