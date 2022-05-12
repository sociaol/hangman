<?php
/*
 * File: hangman.php
 * Project: Project 2
 * File Created: Sunday, 21st March 2021 3:51:42 pm
 * Author: Hayden Kowalchuk
 * -----
 * Copyright (c) 2021 Hayden Kowalchuk, Hayden Kowalchuk
 * License: BSD 3-clause "New" or "Revised" License, http://www.opensource.org/licenses/BSD-3-Clause
 */

require_once('util.php');

/* Hangman */
/* Stored in session:
current category
current word
correct letters
incorrect letters
player has 6 incorrect chances then lose
*/

define("HANGMAN_CHANCES", 6);

/* restores state of current game */
function hangman_acquire()
{
  /* Game in progress */
  if (isset($_SESSION['hangman_game']) && $_SESSION['hangman_game'] == true) {
  } else {
    /*Game not started but we somehow got here?*/
    header("location:newgame.php");
  }
}

/* starts a new game of hangman */
function hangman_start($word, $category)
{
  _set("hangman_word", $word);
  _set("hangman_category", $category);
  _set("hangman_correct", array());
  _set("hangman_wrong", array());
  _set("hangman_game", true);
}

function hangman_parse_input()
{
  if (isset($_POST['choice'])) {
    $choice = $_POST['choice'];
    if (strpos(_get('hangman_word'), $choice) !== false) {
      $arr = _get('hangman_correct');
      array_push($arr, $choice);
      _set('hangman_correct', $arr);
    } else {
      $arr = _get('hangman_wrong');
      array_push($arr, $choice);
      _set('hangman_wrong', $arr);
    }
  }
}

/* output functions */

function hangman_output_letters()
{
  echo "<form method=\"post\">";
  for ($ch = ord('A'); $ch <= ord('Z'); ++$ch) {
    $char = chr($ch);
    if (in_array($char, _get("hangman_correct")) || in_array($char, _get("hangman_wrong"))) {
      echo "<button class=\"letter\" disabled>" . $char . "</button>\n";
    } else {
      echo "<button class=\"letter\" type=\"submit\" name=\"choice\" value=\"" . $char . "\">" . $char . "</button>\n";
    }
  }
  /* Unneeded */
  //echo "<br><br><button class=\"letter\" type=\"submit\" name=\"destroy\" value=\"1\">Reset</button>";
  echo "</form>";
}

function hangman_output_wrong()
{
  $wrong = _get("hangman_wrong");
  foreach ($wrong as $letter) {
    echo "<button class=\"letter\" disabled>" . $letter . "</button>\n";
  }
}

function hangman_output_word()
{
  $word = _get("hangman_word");
  $letters = str_split($word);
  foreach ($letters as $char) {
    if ($char == ' ') {
      echo "<div class=\"underscore blank\">&nbsp;</div>\n";
      continue;
    }
    if (in_array($char, _get("hangman_correct"))) {
      echo "<div class=\"underscore\">" . $char . "</div>\n";
    } else {
      echo "<div class=\"underscore\">&nbsp;</div>\n";
    }
  }
}

function hangman_output_overlay($text)
{
  /* Destroy our current game */
  _set("hangman_game", false);

  $word = _get("hangman_word");
  $word_len = hangman_word_len();
  $guesses = count(_get("hangman_wrong")) + $word_len;
  $pct = round((floatval($word_len) / $guesses) * 100.0, 2);
  if (hangman_loss()) {
    $pct = round(0, 2);
    $pct_string = "<h2>Losses count as (<span class=\"red\">{$pct}%</span>)</h2>";
  } else {
    $pct_string = "<h2>Took <span class=\"yel\">{$guesses}</span> guesses to get <span class=\"yel\">{$word_len}</span> letters correct! (<span class=\"yel\">{$pct}%</span>)</h2>";
  }

  $html = <<<"EOT"
<div id="myNav" class="overlay future">
  <div class="overlay_content">
    <h1>$text</h1>
    <h2>The answer was:</h2>
    <h2>{$word}</h2><br><br>
    {$pct_string}
    <h3>score will be saved to global leaderboards</h3>
    <a href="newgame.php">Play Again!</a><br><br>
    <a href="index.php">Leave</a>
  </div>
</div>
EOT;
  echo $html;
  if (isset($_SESSION['UserData']['username'])) {
    user_record_game($_SESSION['UserData']['username'], $word_len, $pct);
  }
}

function hangman_output_image()
{
  $wrong_guesses = count(_get("hangman_wrong"));
  if ($wrong_guesses) {
    $wrong_guesses = ($wrong_guesses > 6 ? 6 : $wrong_guesses);
    echo "<img src=\"images/step_{$wrong_guesses}.png\" alt=\"hanged person\" id=\"person\">\n";
  }
}

/* Win/Loss/Progress */

function hangman_word_len()
{
  $word = _get("hangman_word");
  $len = strlen($word) - substr_count($word, " ");
  return $len;
}

function hangman_won()
{
  /* check to see if all letters have been filled */
  $temp = _get("hangman_word");
  foreach (_get("hangman_correct") as $letter) {
    $temp = str_replace($letter, "", $temp);
  }
  $temp = str_replace(" ", "", $temp);
  $won = strlen($temp) == 0;
  return $won;
}

function hangman_loss()
{
  $loss = count(_get("hangman_wrong")) > HANGMAN_CHANCES;
  return $loss;
}

function hangman_guesses_left()
{
  return HANGMAN_CHANCES - count(_get("hangman_wrong"));
}
