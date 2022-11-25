<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>
<?php include("utilities_my_bids.php")?>
<div class="container">

<h2 class="my-3">My bids</h2>

<?php
    //obtain email of the user currently logged in
    $email = $_SESSION['email'];
    //store current date and time in a variable
    $now = new DateTime();
    //obtain bids placed by this buyer from the database
    $sql = "SELECT * FROM auction1 INNER JOIN bid ON bid.auctionId = auction1.auctionId WHERE bid.email = '$email';";
    $result = mysqli_query($con, $sql);
    $check_bid = mysqli_num_rows($result);
    if ($check_bid > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $item_id = $row['auctionId'];
        $title = $row["title"];
        $description = $row["details"];
        $num_bids = $row["num_bids"];
        $end_date = new DateTime($row["endDate"]);
        $my_bid = $row['price'];
        //check if item is in 'buy' table
        $sql_buy = "SELECT * FROM buy WHERE auctionId = $item_id;";
        $result_buy = mysqli_query($con, $sql_buy);
        $check_buy = mysqli_num_rows($result_buy);
        //if it is, set the current price as the 'buy now' price
        if ($check_buy >0) {
            $sql_get_price = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
            $result_get_price = mysqli_query($con, $sql_get_price);
            $check_get_price = mysqli_num_rows($result_get_price);
            if ($check_get_price>0) {
                while ($row = mysqli_fetch_assoc($result_get_price)) {
                    $current_price = $row['buyNowPrice'];
                }
            }
        }
        //if item not in buy now table, check if any bids have been placed
        //if no bids were placed and item not in buy now table, set current price as the starting price
        else if ($check_buy == 0 and $num_bids==0) {
            $current_price = $row["startingPrice"];
        }
        //if bids were placed but item not in buy now table, set the current price as the highest bid placed
        else {
            $sql_max = "SELECT MAX(price) FROM bid WHERE auctionId = $item_id;";
            $result_max = mysqli_query($con, $sql_max);
            $check_max = mysqli_num_rows($result_max);
            if ($check_max>0){
                while ($row = mysqli_fetch_assoc($result_max)) {
                    $current_price = $row['MAX(price)'];
                }
            }
        }

        //check that the auction has not ended
        if ($end_date > $now) {
            if ($my_bid < $current_price) {
                print_bids_li_red($item_id, $title, $my_bid, $description, $current_price, $num_bids, $end_date);
            }
            else {
            //if auction is indeed active, print bid
                print_bids_li($item_id, $title, $my_bid, $description, $current_price, $num_bids, $end_date);
            }
        }
    }
    }
include_once("footer.php")?>
