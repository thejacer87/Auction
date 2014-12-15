<?php
    session_start();
    $reserve_message = "";
    
    if ((!filter_input(INPUT_POST, 'value'))) {
            header("Location: item.php");
            exit;
    }

    include("connect.php");
    connectToDB(); // method from connect.php

    $sql = "INSERT INTO bids (id, items_id, users_id, time, value) "
            . "VALUES (NULL, '".filter_input(INPUT_POST, 'items_id')."', "
            . "(SELECT id FROM users WHERE email = '".filter_input(INPUT_POST, 'email')."') "
            . ", NOW(), '".filter_input(INPUT_POST, 'value')."')";
    $result =  mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
    
    if(filter_input(INPUT_POST, 'reserve_price') > filter_input(INPUT_POST, 'value')){
        $reserve_message .= "Reserve price not met! ";
    }
    //free results
    mysqli_free_result($result);

    //close connection to MySQL
    mysqli_close($mysqli);  
    
    header("refresh:5; url=item.php?items_id=".filter_input(INPUT_POST, 'items_id'));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>jbay</title>
<!--        <style type="text/css">
            <?php include "css/myStyle.css"?>
        </style>-->
        <link rel="shortcut icon"  href="images/icon.png">
    </head>    
    <body>
        <h1>Registering Bid...</h1>
        <h4><?php echo $reserve_message;?></h4>
        <p>
            You will be redirected in 5 seconds. Click <a href="item.php?items_id=<?php echo filter_input(INPUT_POST, 'items_id');?>">here</a>
            if it does not automatically redirect you.
        </p>
    </body>
</html>