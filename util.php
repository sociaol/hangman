<?php
/*
 * File: util.php
 * Project: Project 2
 * File Created: Sunday, 21st March 2021 3:50:53 pm
 * Author: Hayden Kowalchuk 
 * -----
 * Copyright (c) 2021 Hayden Kowalchuk, Hayden Kowalchuk
 * License: BSD 3-clause "New" or "Revised" License, http://www.opensource.org/licenses/BSD-3-Clause
 */

/* Debugging on CODD */
/*
error_reporting(E_ALL);
ini_set('display_errors',1);
*/

/* override for fixing session issues*/
ini_set('session.save_path',dirname(__FILE__).'/tmp');

 //Johnathan's part
function footerFunction()
{
  echo
    '
  <div id="w3c">
    <a href="https://validator.w3.org/#validate_by_input"><img src="images/xhtml.png" alt="xhtml val"></a>
    <a href="https://jigsaw.w3.org/css-validator/"><img src="images/css.png" alt="css val"></a>
  </div>
  ';
}

function backButton()
{
  echo
    '<div id="back">
    <a href="index.php"><img src="images/back.png" alt="back" width="100" height="100"></a>
  </div>
  ';
}

/* helper to reduce typing */
function _set($var, $val)
{
  $_SESSION[$var] = $val;
}

function _get($var)
{
  return $_SESSION[$var];
}

/* random string to avoid caching */
function rs($length = 8)
{
  $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
  $rs = substr(str_shuffle($chars), 0, $length);
  return $rs;
}

/* Read file as csv into array */
function csv2array($filename)
{
  $array = array_map('str_getcsv', file($filename));
  return $array;
}

/* Write array to a csv file*/
function array2csv($filename, $array)
{
  $fd = fopen($filename, "w");

  foreach ($array as $line) {
    fputcsv($fd, $line);
  }
  fclose($fd);
}
