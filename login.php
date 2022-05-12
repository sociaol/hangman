<!--- File: login.php
 * Project: Project 2
 * File Created: 3/20/21
 * Author: Johnathan Nguyen
 -->
<?php
require_once('util.php');
require_once('user_mgmt.php');
session_start(); /* Starts the session */
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link href="loginsubmit.css" type="text/css" rel="stylesheet">
</head>


<body>
    <?php
    $users = get_users();
    /* Check Login form submitted */
    if (isset($_POST['submit'])) {

        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $temp_user = check_user_exists($username);

        /* Check username and password existence in defined array */
        if ($temp_user !== false) {
            if ($temp_user['pass'] == $password) {
                /* Success: Set session variables and redirect to Protected page  */
                $_SESSION['UserData']['username'] = $username;
                header("location:newgame.php");
                exit;
            }
        }
        /*Unsuccessful attempt: Set error message */
        $msg = "<span style='color:red'>Invalid Login Details</span>";
    }
    ?>
    <form method="post" name="Login_Form">
        <div id="form">
            <?php if (isset($msg)) { ?>
                <table>
                    <tr>
                        <td><?php echo $msg; ?></td>
                    </tr>
                </table>
            <?php } ?>
            <fieldset>
                <legend>Login: </legend>
                <!---username has 16-character box -->
                <strong>Username: </strong>
                <input type="text" name="username" class="input" size="16">
                <br />
                <br />
                <!---password has 16-character box -->
                <strong>Password: </strong>
                <input type="text" name="password" class="input" size="16">
                <br />
                <br />
                <!---submit button -->
                <input name="submit" type="submit" value="Login" class="function">
            </fieldset>
        </div>
    </form>

    <?php
    //footer function
    footerFunction();
    backButton();
    ?>

</body>

</html>