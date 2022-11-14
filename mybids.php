<?php include_once("header.php")?>
<?php require("utilities.php");?>
<?php include ("connection.php");?>
<?php require('utilities_my_bids.php');?>

    <div class="container">

    <h2 class="my-3">My bids</h2>

<?php

$email = $_SESSION['email'];

$sql = "SELECT * FROM auction1 INNER JOIN bid ON bid.auctionId = auction1.auctionId WHERE bid.email = '$email';";
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
        $my_bid = $row['price'];
        if ($my_bid < $current_price) {
            print_bids_li_red($item_id, $title, $my_bid, $description, $current_price, $num_bids, $end_date);
        } else {
            print_bids_li($item_id, $title, $my_bid, $description, $current_price, $num_bids, $end_date);
        }
    }
    }?>




// This page is for showing a user the auction listings they've made.
// It will be pretty similar to browse.php, except there is no search bar.
// This can be started after browse.php is working with a database.
// Feel free to extract out useful functions from browse.php and put them in
// the shared "utilities.php" where they can be shared by multiple files.


// TODO: Check user's credentials (cookie/session).

// TODO: Perform a query to pull up their auctions.

// TODO: Loop through results and print them out as list items.



<?php include_once("footer.php")?>