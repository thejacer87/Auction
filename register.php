<?php
    //confirm all fields from form were filled
    if (filter_input(INPUT_POST, 'f_name') && filter_input(INPUT_POST, 'l_name')
            && filter_input(INPUT_POST, 'email') && filter_input(INPUT_POST, 'password')) {
    
        include("connect.php");
        connectToDB(); // method from connect.php

        //create and issue the query
        $targetemail = strtolower(filter_input(INPUT_POST, 'email'));
        $sql = "SELECT * FROM users WHERE email = '".$targetemail."'";

        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));


        //get the number of rows in the result set; should be 1 if a match
        if (mysqli_num_rows($result) > 0) {
            $output = "<p>Oops, that email has been registered.<br>
                          Please use a different email address for a new account.<br>
                          Or return to the <a href=\"index.php\">login page</a>.</p>";
        }else {
            //get form information
            $email = strtolower(filter_input(INPUT_POST, 'email')); 
            $password = filter_input(INPUT_POST, 'password');
            $fname = filter_input(INPUT_POST, 'f_name');
            $lname = filter_input(INPUT_POST, 'l_name');
            $insert_sql = "INSERT INTO users (f_name, l_name, password, email)
                    VALUES ('".$fname."', '".$lname."',
                    PASSWORD('".$password."'), '".$email."')";

            mysqli_query($mysqli, $insert_sql) or die(mysqli_error($mysqli));
            $output = "<p>Your new account has been created. Thank your for joining us!
                          Return to the <a href=\"index.php\">login page</a>.</p>";
        }   

        //free results
        mysqli_free_result($result);
        //close connection to MySQL
        mysqli_close($mysqli);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>jbay Registration</title>
        <style type="text/css">
            <?php include "css/myStyle.css"?>
        </style>
        <link rel="shortcut icon"  href="images/icon.png">
    </head>
    
    <body>
        <header>
            <h1>Sign up for jbay</h1>
        </header>
        <section id="register">
            <h1>Registration:</h1>
            <form method="post" action="register.php">
                <p><input type="text" name="f_name" placeholder=" John" required/></p>
                <p><input type="text" name="l_name" placeholder=" Smith" required/></p>
                <p><input type="email" name="email" placeholder=" name@domain.com" required/></p>
                <p><input type="password" name="password" placeholder=" password" required/></p>
                <p><input type="submit" name="submit" value="Register"/></p>
            </form>
            <p><button id="go_back" onclick="history.go(-1);">Go Back</button></p>
        </section>
        <?php echo $output;?>
    </body>
</html>


