<?php
    session_start();
    include ("connect.php");
    if (!filter_input(INPUT_GET, 'items_id')) {
            header("Location: userlogin.php");
            exit;
    }
    else {
        include ("bidInfo.php");
        include ("bidHistory.php");
    }
    
?>

<!DOCTYPE htm>
<html>
    <head>
        <title>jbay</title>
<!--        <style type="text/css">
            <?php include "css/myStyle.css"?>
        </style>-->
        <link rel="shortcut icon"  href="images/icon.png">
    </head>    
    <body>
        <?php echo $display_block?>
        <p><a href="userlogin.php">Back to Auction List</a></p>
        <h1>Place Bid:</h1>
        <form method="post" action="placeBid.php">
            <p>
                <label>Your bid: $ </label><input type="number" value="<?php echo $high_bid_price + 0.01; ?>" min="<?php echo $high_bid_price + 0.01; ?>" step="0.01" name="value" >          
                <input type="submit" name="submit" <?php if(($_SESSION['email'] == $item_owner)){echo "disabled = 'true'";} ?> value="Place Bid"/>
                <?php if(($_SESSION['email'] == $item_owner)){echo "You can not bid on your auction!";} ?>
            </p>
            <p><input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>" ></p>
            <p><input type="hidden" name="items_id" value="<?php echo filter_input(INPUT_GET, 'items_id');?>" ></p> 
            <p><input type="hidden" name="reserve_price" value="<?php echo $item_res_price;?>" ></p>  
        </form>
        <h1>Bidding History</h1>
        <?php echo $history_block?>
    </body>
</html>
