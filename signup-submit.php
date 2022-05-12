<!--- File: signup-submit.php
 * Project: Project 2
 * File Created: 3/20/21
 * Author: Johnathan Nguyen
 -->
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title>Signup - Submit Page</title>
        <link href="loginsubmit.css" type="text/css" rel="stylesheet">
    </head>

    <body>
    <?php
        require_once('util.php');
        require_once('user_mgmt.php');
    ?>

    <?php
        $validationFail = 1;
        //validating there is a value for each field
        if(isset($_POST['username']) && isset($_POST['password'])     ) {
            $validationFail = 0;
        }

        /*  validating username, can't be empty         */
        if (empty($_POST["username"])) {
            $validationFail = $validationFail + 1;
        }
        /*  validating password, can't be empty         */
        if (empty($_POST["password"])) {
            $validationFail = $validationFail + 1;
        }
        /* Check if username is already registered */
        if(check_user_exists($_POST['username']) !== false){
            $validationFail = $validationFail + 1;
        }

        /*if validation passes with no errors append to userdetail.txt and welcome user */
        if ($validationFail == 0) {
            add_user($_POST['username'], $_POST['password']);
        ?>
        <legend>Congratulations, Your Sign Up was Successful!</legend>
        <?php
            echo "<strong class='welcome'>Welcome to Hangman, </strong>";
            echo '<strong class="welcome"> ' . $_POST["username"] . '</strong>' ;
           
        ?>
        
            <br>
            <br>
            <a href="login.php">Click here to log in and play!</a>
            <br>
            <br>
        <?php
        }
            //else, sorry page
            else {
                echo "<h3>Error! Invalid data.</h3>";
                echo "<br>";
                echo "We're sorry. You submitted invalid user information. Please go back and try again.";
                echo "<br>";
                echo "<br>";
                echo "<br>";
              
        }
        ?>

        <?php
			//footer function 
			footerFunction();
		?>
    </body>
</html>