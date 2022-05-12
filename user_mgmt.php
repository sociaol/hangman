<?php
/*
 * File: user_mgmt.php
 * Project: Project 2
 * File Created: Wednesday, 24th March 2021 12:48:08 pm
 * Author: Hayden Kowalchuk 
 * -----
 * Copyright (c) 2021 Hayden Kowalchuk, Hayden Kowalchuk
 * License: BSD 3-clause "New" or "Revised" License, http://www.opensource.org/licenses/BSD-3-Clause
 */
require_once('util.php');

function get_users()
{
  $data = csv2array('userdetail.txt');
  // Remove first line comment
  array_shift($data);
  /* replace keys & sanitize data and replace nulls with proper values */
  foreach ($data as $idx => $el) {
    $data[$idx]['user']       = $el[0];
    $data[$idx]['pass']       = $el[1];
    $data[$idx]['num_games']  = $el[2];
    $data[$idx]['avg_length'] = $el[3];
    $data[$idx]['correct_pct'] = $el[4];
    unset($data[$idx][0]);
    unset($data[$idx][1]);
    unset($data[$idx][2]);
    unset($data[$idx][3]);
    unset($data[$idx][4]);

    // sanitize num_games;
    if (!isset($data[$idx]['num_games']) || $data[$idx]['num_games'] == null) {
      $data[$idx]['num_games'] = 0;
    }
    // Dont "fix" avg_length and correct_pct so we can handle them correctly later
  }

  return $data;
}

function update_users($array)
{
  $fd = fopen('userdetail.txt', 'w');
  fputcsv($fd, array('user', 'password', 'num_games', 'avg_length', 'correct_pct'));
  foreach ($array as $line) {
    fputcsv($fd, $line);
  }
  fclose($fd);
}

/* checks if user is present and returns the user if so, otherwise returns false */
function check_user_exists($user){
  $user = trim($user);
  $data = get_users();
  foreach ($data as $el) {
  if($el['user'] == $user)
    return $el;
  }
  return false;
}

function add_user($username, $password)
{
  $user = array();
  $user['user']       = trim($username);
  $user['pass']       = trim($password);
  $user['num_games']  = 0;
  $user['avg_length'] = null;
  $user['correct_pct'] = null;
  $fd = fopen('userdetail.txt', 'a');
  fputcsv($fd, $user);
  fclose($fd);
}

function user_record_game($user, $length, $correct_pct)
{
  $data = get_users();
  foreach ($data as $idx => $el) {
    /* Found the user now update stats */
    if ($el['user'] == $user) {
      $data[$idx]['num_games'] = intval($data[$idx]['num_games']) + 1;
      /* update average phrase length as running average */
      if (!isset($data[$idx]['avg_length']) || $data[$idx]['avg_length'] == null) {
        $data[$idx]['avg_length'] = $length;
      } else {
        $data[$idx]['avg_length'] = (floatval($data[$idx]['avg_length']) + $length) / 2.0;
      }
      /* update average correct percentage as running average */
      if (!isset($data[$idx]['correct_pct']) || $data[$idx]['correct_pct'] == null) {
        $data[$idx]['correct_pct'] = $correct_pct;
      } else {
        $data[$idx]['correct_pct'] = (floatval($data[$idx]['correct_pct']) + $correct_pct) / 2.0;
      }
    }
  }
  update_users($data);
}