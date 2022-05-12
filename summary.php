<!--- File: index.php
 * Project: Project 2
 * File Created: 3/20/21
 * Author: Johnathan Nguyen
 -->
 <?php
require_once('util.php');
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <title>Hangman</title>
    <link href="style.css<?php echo '?' . rs(7); ?>" type="text/css" rel="stylesheet">
</head>

<body>
    <h1>Leader Info & Summary</h1>
    <img src="images/summary.jpg" alt="summary">


    <?php
        //footer function
        footerFunction();
        backButton();
    ?>
</body>

</html>