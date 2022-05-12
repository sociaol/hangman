<?php
/*
 * File: leaderboard.php
 * Project: Project 2
 * File Created: Wednesday, 24th March 2021 1:53:03 pm
 * Author: Hayden Kowalchuk 
 * -----
 * Copyright (c) 2021 Hayden Kowalchuk, Hayden Kowalchuk
 * License: BSD 3-clause "New" or "Revised" License, http://www.opensource.org/licenses/BSD-3-Clause
 */

// rank, user, games played, average length, percent correct, composite (sorting)

require_once('util.php');
require_once('user_mgmt.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hangman | Leaderboard</title>
  <link href="style.css<?php echo '?' . rs(7); ?>" rel="stylesheet">
  <link href="play.css<?php echo '?' . rs(7); ?>" rel="stylesheet">
  <link href="leaderboard.css<?php echo '?' . rs(7); ?>" rel="stylesheet">
</head>

<body>
  <div class="main future">
    <div class="leaderboard_header">
      <h1>Leaderboard</h1>
    </div>
    <table id="leaderboard">
      <thead>
        <tr>
          <th>Rank</th>
          <th>Username</th>
          <th>Games Played</th>
          <th>Average Length</th>
          <th>Guess Correct %</th>
          <th>Composite Score</th>
        </tr>
      </thead>
      <tbody>
        <?php
        /* Dynamically generate the leaderboard */
        $users = get_users();

        /* remove users that havent played */
        foreach ($users as $idx => $user) {
          if (intval($user['num_games']) == 0 || $user['avg_length'] == null) {
            unset($users[$idx]);
          }
        }

        /* Comparison function based on new composite point score */
        function cmp($a, $b)
        {
          if ($a['avg_length'] == null || $a['correct_pct'] == null) {
            return -1;
          }
          $a_comp = intval($a['num_games']) * floatval($a['avg_length']) * floatval($a['correct_pct']);
          $b_comp = intval($b['num_games']) * floatval($b['avg_length']) * floatval($b['correct_pct']);
          if ($a_comp == $b_comp) {
            return 0;
          }
          return ($a_comp > $b_comp) ? -1 : 1;
        }

        /* Sort based on new composite score and reindex */
        uasort($users, 'cmp');
        $users = array_values($users);

        /* Output the html for each user that made it through the filtering */
        foreach ($users as $idx => $user) {
          $name = $user['user'];
          $games = intval($user['num_games']);
          $length = $user['avg_length'];
          $pct = round(floatval($user['correct_pct']), 0);
          $comp = round(intval($user['num_games']) * floatval($user['avg_length']) * floatval($user['correct_pct']), 0);
          /* Rank Styling */
          $rank_cat = ($idx < 3 ?  "top" : "other");
          $medal = ($idx < 3 ?  "_" . ($idx + 1) : "");
          $rank = ($idx < 3 ?  "&nbsp;" : $idx + 1);
          $html = <<<"EOT"
        <tr>
          <td class="rank"><span class="{$rank_cat} ${medal}">{$rank}</span></td>
          <td>{$name}</td>
          <td>{$games}</td>
          <td>{$length} Letters</td>
          <td>{$pct}%</td>
          <td>{$comp}pts</td>
        </tr>

EOT;
          echo $html;
        }
        ?>
      </tbody>
    </table>
  </div>
  <?php
  //footer function
  footerFunction();
  backButton();
  ?>
</body>

</html>