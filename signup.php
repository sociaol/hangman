<!--- File: signup.php
 * Project: Project 2
 * File Created: 3/20/21
 * Author: Johnathan Nguyen
 -->
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <title>Sign Up Page</title>
    <link href="loginsubmit.css" type="text/css" rel="stylesheet">
</head>

<body>
    <?php
    require_once('util.php');
    ?>
    <br />
    <div id="form">
        <!---Form to create new account & encodes data through POST-->
        <form action="signup-submit.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>New User Signup: </legend>
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
                <input type="submit" value="Sign Up" class="function">
            </fieldset>
        </form>
    </div>
    <?php
    //footer function
    footerFunction();
    backButton();
    ?>
</body>

</html>