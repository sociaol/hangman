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
    <h1 id="welcome">Welcome to Hangman</h1>
    <img src="images/Noose.png" alt="noose">

    <img src="images/step_6.png" alt="figure">
    <div id="buttons">
        <a href="signup.php">
            <div class="function">Sign Up</div>
        </a>
        <a href="login.php">
            <div class="function">Log In</div>
        </a>
        <a href="newgame.php">
            <div class="function">Play</div>
        </a>
        <a href="leaderboard.php">
            <div class="function">Leaderboard</div>
        </a>
    </div>
    <div id="summary">
        <a href="summary.php">Leader Info & Summary</a>
    </div>

    <?php
    //footer function
    footerFunction();
    ?>
</body>

</html>