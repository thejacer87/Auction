<?php
    session_start();
    include ("addAuction.php");
    include ("filter.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Auction</title>
<!--        <style type="text/css">
            <?php include "css/myStyle.css"?>
        </style>-->
        <link rel="shortcut icon"  href="images/icon.png">
    </head>
    
    <body>  
        <h1>Logged in as <?php echo $_SESSION['email']; ?></h1> 
        <form method="post" action="#">
            <p><label>Item Name: </label><input type="text" name="name" required/></p>
            <textarea rows="10" cols="50" name="desc" placeholder="Enter Description..." required ></textarea>
            <p>
                <label>Category: </label>
                <select name="type">
                <?php 
                    foreach($categories as $category) {
                        $str = str_replace('_', ' ', $category);
                        echo "<option value=".strtolower($category).">".$str."</option>";
                    }
                ?>
                </select>
            </p>
            <p><label>Reserve Price: $</label><input type="number" value="0.01" step="0.01" name="res_price" ></p>
            <p>
                <input type="submit" name="submit" value="Create Auction"/>
                <a href="userlogin.php"><input type="button" value="Back to Auctions"/></a>
            </p>
        </form>
        <span><?php echo $message; ?></span>
    </body>
</html>

