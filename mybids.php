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
    $check = mysqli_num_rows($result);
    if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $item_id = $row['auctionId'];
        $title = $row["title"];
        $description = $row["details"];
        $num_bids = $row["num_bids"];
        $image = $row['image'] ;
        echo "<img src='images/".$image."'>";
        if ($num_bids == 0) {
            $current_price = $row["startingPrice"];
        } else {
            $current_price = $row["reservePrice"];
        }
        $end_date = new DateTime($row["endDate"]);
        $my_bid = $row['price'];
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
