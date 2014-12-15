<?php
    include ("login.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>jbay</title>
        <style type="text/css">
            <?php include "css/myStyle.css"?>
        </style>
        <link rel="shortcut icon"  href="images/icon.png">
    </head>
    
    <body>
        <header>
            <h1>Welcome to jbay.</h1>
        </header>
        <section id="login">
            <h1>Login:</h1>
            <form method="post" action="#">
                <p><input type="email" name="email" placeholder=" email" autofocus/></p>
                <p><input type="password" name="password" placeholder=" password"/></p>
                <p><input type="submit" name="submit" id="button" value="Login"/></p>
            </form>
            <span><?php echo $error; ?></span>
        <a href="register.php">Create New Account</a>
        </section>
        <section id="notes">
            Notes:<br>
            <p id="devNotes">jbay is a project I made to display some of my programming skills.
                It's is auction website, similar to ebay. It doesn't have all of the functionality of ebay, but it gets the job done.
                <br>I used PHP and mySQL to build the site and keep track of all the items and users in the database.
                <br><br>Warning: YOU CAN'T ACTUALLY PURCHASE ANY ITEMS.</p>
        </section>
    </body>
</html>

