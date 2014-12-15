<?php
    session_start();
    include ("connect.php");
    $error='';
   
    if (filter_input(INPUT_POST,'submit')) {
        if (!(filter_input(INPUT_POST,'email')) || !(filter_input(INPUT_POST,'password'))) {
            $error = "Email or Password is invalid";
        } else {
            $email = strtolower(filter_input(INPUT_POST,'email'));
            $password = filter_input(INPUT_POST,'password');

            connectToDB(); // method from connect.php

            $sql = "SELECT * FROM users WHERE password = PASSWORD('".$password."') AND email = '".$email."'";
            $rows = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));;

            if (mysqli_num_rows($rows) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header("location: userlogin.php");
            } else {
                $error = "Email or Password is invalid";
            }
            
            mysqli_close($mysqli); 
        }
    }
?>
