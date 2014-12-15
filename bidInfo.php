<?php
    connectToDB(); // method from connect.php
    $display_block = "<h1>Logged in as ".$_SESSION['email']."</h1>";

    $high_bid_sql = "SELECT i.name, i.description, i.reserve_price, i.owner, u.email, b.value"
                  . " FROM items i INNER JOIN bids b ON i.id = b.items_id"
                  . " INNER JOIN users u on b.users_id = u.id WHERE i.id = ".filter_input(INPUT_GET, 'items_id')
                  . " ORDER BY b.time DESC";
    $high_bid_result = mysqli_query($mysqli, $high_bid_sql) or die(mysqli_error($mysqli));
    $display_block .= 
            "<table width=\"100%\" cellpadding=\"3\" cellspacing=\"1\" border=\"1\">
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Highest Bidder</th>
                    <th>Current Bid</th>
                </tr>";
    
    if (mysqli_num_rows($high_bid_result) < 1) {
        $item_sql = "SELECT * FROM items WHERE id = ".filter_input(INPUT_GET, 'items_id');
        $item_result = mysqli_query($mysqli, $item_sql) or die(mysqli_error($mysqli));
        
        $item_info = mysqli_fetch_array($item_result);
        $item_name = stripslashes($item_info['name']);
        $item_owner = stripslashes($item_info['owner']);
        $item_desc = nl2br(stripslashes($item_info['description']));
        $item_res_price = $item_info['reserve_price'];            


        $display_block .=
            "<tr>
                <td width=\"15%\" valign=\"top\"><em>Name:</em><strong> ".$item_name."</strong><br><br><em>Seller:</em> <strong>".substr($item_owner, 0, strpos($item_owner, '@'))."</strong></td>
                <td width=\"55%\" valign=\"top\">".$item_desc."</td>
                <th width=\"15%\">--</th>
                <th width=\"15%\">No bids!!</th>
            </tr></table>";
    } else {
        

        $high_bid_info = mysqli_fetch_array($high_bid_result);
        $item_name = stripslashes($high_bid_info['name']);
        $item_owner = stripslashes($high_bid_info['owner']);
        $user = stripslashes($high_bid_info['email']);
        $item_desc = nl2br(stripslashes($high_bid_info['description']));
        $high_bid_price = $high_bid_info['value'];
        $item_res_price = $high_bid_info['reserve_price'];  

        $display_block .= 
            "<tr>
                <td width=\"15%\" valign=\"top\"><em>Name:</em><strong> ".$item_name."</strong><br><br><em>Seller:</em> <strong>".substr($item_owner, 0, strpos($item_owner, '@'))."</strong></td>
                <td width=\"55%\" valign=\"top\">".$item_desc."</td>
                <th width=\"15%\">".substr($user, 0, strpos($user, '@'))."</th>
                <th width=\"15%\">$".$high_bid_price."</th>
            </tr></table>";

        //free result
        mysqli_free_result($high_bid_result);
    }
?>    
