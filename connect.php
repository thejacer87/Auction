<?php
    function connectToDB() {
            global $mysqli;

            $mysqli = mysqli_connect("localhost", "thejacer87", "Matthew8", "Auction");

            if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
            }
    }
?>