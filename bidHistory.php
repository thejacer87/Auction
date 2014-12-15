<?php
    connectToDB(); // method from connect.php
    $bid_history_sql = "SELECT items.id items_id, users.email, bids.time, bids.value"
        . " FROM items INNER JOIN bids ON items.id = bids.items_id"
        . " INNER JOIN users ON bids.users_id = users.id WHERE items.id = ".filter_input(INPUT_GET, 'items_id')
        . " ORDER BY bids.time DESC";
    
    $bid_history_result = mysqli_query($mysqli, $bid_history_sql) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($bid_history_result) < 1) {
        $history_block = 
            "<table width=\"50%\" cellpadding=\"3\" cellspacing=\"1\" border=\"1\">
                <tr>
                    <th>There is no bidding history for this item.</th>
                </tr>
            </table>";
    } else {
        $history_block = 
            "<table width=\"50%\" cellpadding=\"3\" cellspacing=\"1\" border=\"1\">
                <tr>
                    <th>User</th>
                    <th>Time</th>
                    <th>Bid</th>
                </tr>";
        
        while ($bid_info = mysqli_fetch_array($bid_history_result)) {
            $user = stripslashes($bid_info['email']);
            $bid_time = date('Y M d H:i:s', strtotime($bid_info['time']));
            $bid_price = $bid_info['value'];
            $items_id = $bid_info['items_id'];

            $history_block .= 
                "<tr>
                    <td width=\"30%\" valign=\"top\">".substr($user, 0, strpos($user, '@'))."</td>
                    <td width=\"40%\" valign=\"top\">".$bid_time."</td>
                    <th width=\"30%\">$".$bid_price."</th>
                </tr>";
        }

        //free result
        mysqli_free_result($bid_history_result);

        //close up the table
        $history_block .= "</table>";
    }

     //close connection to MySQL
    mysqli_close($mysqli);
?>
