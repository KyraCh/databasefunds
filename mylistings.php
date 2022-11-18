<?php include_once("header.php")?>
<?php require("utilities.php");?>
    <div class="container">
    <h2 class="my-3">My listings</h2>
<?php
//connect to database
include ("connection.php");
    //obtain email of the user currently logged in
    $email = $_SESSION['email'];
    //obtain items sold by this seller from the database
    $sql = "SELECT * FROM  auction1 WHERE email = '$email';";
    $result = mysqli_query($con, $sql);
    $check = mysqli_num_rows($result);
    if ($check > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $item_id = $row['auctionId'];
            $title = $row["title"];
            $description = $row["details"];
            $num_bids = $row["num_bids"];
            if ($num_bids == 0) {
                $current_price = $row["startingPrice"];
            } else {
                $current_price = $row["reservePrice"];
            }
            $end_date = new DateTime($row["endDate"]);
            //print the listing
            print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
        }
}
include_once("footer.php")?>