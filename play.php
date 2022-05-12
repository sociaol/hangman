<?php
/*
 * File: play.php
 * Project: Project 2
 * File Created: Sunday, 21st March 2021 12:54:21 pm
 * Author: Hayden Kowalchuk 
 * -----
 * Copyright (c) 2021 Hayden Kowalchuk, Hayden Kowalchuk
 * License: BSD 3-clause "New" or "Revised" License, http://www.opensource.org/licenses/BSD-3-Clause
 */
require_once('util.php');
require_once('hangman.php');
require_once('user_mgmt.php');

session_start();

/* helper for debugging */
if (isset($_REQUEST['destroy'])) {
  session_destroy();
}

function hangman_dump()
{
  echo "<pre>";
  print_r($_REQUEST);
  print_r($_SESSION);
  echo "</pre>";
}

/* Get our game state */
hangman_acquire();
hangman_parse_input();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hangman | Play</title>
  <link href="style.css<?php echo '?' . rs(7); ?>" rel="stylesheet">
  <link href="play.css<?php echo '?' . rs(7); ?>" rel="stylesheet">
</head>

<body>
  <?php
  /* check win loss and update user stats */
  if (hangman_won()) {
    hangman_output_overlay("<span class=\"grn\">Well done!</span>");
  } else if (hangman_loss()) {
    hangman_output_overlay("<span class=\"red\">You Lost!</span>");
  }
  ?>
  <div class="main flex">
    <div class="col_hangman">
      <div class="progress_container">
        <img src="images/Noose.png" alt="noose" id="noose">
        <?php
        //hangman_dump();
        hangman_output_image();
        /*
        Unused HTML
        <br>
        <h1>Guesses left:</h1>
        <button class="letter"><?php echo hangman_guesses_left(); ?></button>
        */
        ?>
        <br>
        <?php
        hangman_output_wrong();
        ?>
      </div>
    </div>
    <div class="col_game">
      <div class="row_half" id="top">
        <h1 class="future center">(<?php echo _get("hangman_category"); ?>)</h1>
        <div class="word center">
          <?php
          hangman_output_word();
          ?>
        </div>
      </div>
      <div class="row_half" id="bottom">
        <?php
        hangman_output_letters();
        ?>
      </div>
    </div>
  </div>
  <?php
  /* Footer */
  footerFunction();
  ?>
</body>

</html>