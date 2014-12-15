<?php
    session_start();
    include("connect.php");
    connectToDB(); // method from connect.php
    
    if (filter_input(INPUT_POST, 'submit')){
        
        // verify from was filled out
        if (!(filter_input(INPUT_POST, 'name')) || !(filter_input(INPUT_POST, 'desc'))
                || !(filter_input(INPUT_POST, 'type')) || !(filter_input(INPUT_POST, 'res_price'))) {
            header("Location: addAuctionForm.php");
            exit;
        }
        
        $name = mysqli_real_escape_string($mysqli, filter_input(INPUT_POST, 'name'));
        $desc = mysqli_real_escape_string($mysqli, filter_input(INPUT_POST, 'desc'));
        $type = mysqli_real_escape_string($mysqli, filter_input(INPUT_POST, 'type'));
        $res_price = filter_input(INPUT_POST, 'res_price');
        $email = strtolower(mysqli_real_escape_string($mysqli, $_SESSION['email']));
        
        $message = "<p>Your item is up for bid, you can add more items.</p>";
                
        $sql = "INSERT INTO items (id, name, description, type, reserve_price, owner) "
               . "VALUES (NULL, '".$name."', '".$desc."', '".$type."', ".$res_price.", '".$email."')";

        $result =  mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

        //free results
        mysqli_free_result($result);
        //close connection to MySQL
        mysqli_close($mysqli); 
    
        header("refresh:5; url=addAuctionForm.php");
    }
?>