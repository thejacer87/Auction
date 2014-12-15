<?php
    session_start();
    include("connect.php");
    include("filter.php");
    connectToDB(); // method from connect.php

    $targetemail = $_SESSION['email'];
    $targetpasswd = $_SESSION['password'];
    
    $login_sql = "SELECT f_name FROM users WHERE email = '".$targetemail."' AND password = PASSWORD('".$targetpasswd."')";

    $result = mysqli_query($mysqli, $login_sql) or die(mysqli_error($mysqli));

    // will return 1 if user is registered
    if (mysqli_num_rows($result) == 1) { 
        // creaete welcome message
        $f_name = stripslashes(mysqli_fetch_array($result)['f_name']);
        $welcome_block = "Welcome back, ".$f_name;
    } else {
        //redirect back to login form if not registered
        header("Location: index.php");
        exit;
    }

    // create filter clause
    $filter_post = filter_input(INPUT_POST, 'filter');
    if ($filter_post == "all" || $filter_post == "" ) {$sql_filter_clause = "";}
    else {$sql_filter_clause = "WHERE type = '".$filter_post."'";}
    
    // big ugly query; gets the info needed, i promise;
    $auction_info_sql = 
        "SELECT * FROM (SELECT i.name, i.description, i.type, i.reserve_price, i.id, i.owner, b.value "
        . "FROM items i LEFT OUTER JOIN bids b ON i.id = b.items_id "
        . "INNER JOIN ( SELECT i.id, MAX(b.value) value FROM bids b "
        . "RIGHT OUTER JOIN items i ON b.items_id = i.id "
        . "GROUP BY i.id) my_table ON i.id = my_table.id "
        . "WHERE b.value = my_table.value OR my_table.value IS NULL "
        . "ORDER BY b.time DESC) my_big_table ". $sql_filter_clause;
    
    
    
    $auction_result = mysqli_query($mysqli, $auction_info_sql) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($auction_result) < 1) {
        $display_block = "<p><em>There are no items in this category.<br/>
        Please select a different category.</em></p>";
    } else {
        $display_block = "
        <table cellspacing=\"1\">
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Current Bid</th>
            </tr>";

        while ($item_info = mysqli_fetch_array($auction_result)) {
                $item_name = stripslashes($item_info['name']);
                $item_owner = stripslashes($item_info['owner']);
                $item_desc = nl2br(stripslashes($item_info['description']));
                $item_id = $item_info['id'];
                $item_res_price = $item_info['reserve_price'];
                $cur_bid = "$ ".$item_info['value'];

                if ($cur_bid  == "$ ") {$cur_bid  = "No Bids!";}

                $display_block .= "
                <tr>
                    <td><em>Name:</em><strong> ".$item_name."</strong><br><br><em>Seller:</em> <strong>".substr($item_owner, 0, strpos($item_owner,'@'))."</strong></td>
                    <td width=\"70%\" valign=\"top\">".$item_desc."<img/><br/><br/>
                        <a href=\"item.php?items_id=".$item_id."\"><strong>VIEW AUCTION PAGE</strong></a></td>
                    <td>".$cur_bid."</td>
                </tr>";
        }

        //close up the table
        $display_block .= "</table>";

        //free results
        mysqli_free_result($login_result);
        mysqli_free_result($auction_result);

        //close connection to MySQL
        mysqli_close($mysqli);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Auction Listings</title>
        <style type="text/css">
            <?php include "css/myStyle.css"?>
        </style>
        <link rel="shortcut icon"  href="images/icon.png">
    </head>
    
    <body>  
        <header>
            <h1>
                <?php echo $welcome_block; ?> 
            </h1>
            <p id="logout"><a href="logout.php">logout</a></p>
        </header>
        <section class="container">
            <form method="post" action="addAuctionForm.php">
                <input type="submit" id="create" value="Create Auction"/>
            </form>
        </section>
        <section class="container">
            <form method="post" action="#">
                <label>Filter by Category:</label><br>
                <div class="dropdown">
                    <select name="filter" id="filter">
                        <option value="all">All Categories</option> 
                        <?php 
                            foreach($categories as $category) {
                                $str = str_replace('_', ' ', $category);
                                echo "<option value=\"".strtolower($category)."\">".$str."</option>";
                            }
                        ?>                 
                    </select>
                </div>
                <input type="submit" name="submit" id="go" value="Go">
            </form>
        </section>
        <section class="container">
            <h2>
                Viewing:<em> <?php 
                                if($filter_post == ""){echo "All";}
                                else {echo ucfirst(str_replace('_', ' ', $filter_post));}?>
                        </em>
            </h2>
            <?php echo $display_block; ?>
        </section>
    </body>
</html>
