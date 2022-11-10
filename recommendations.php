<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>

<div class="container">

<h2 class="my-3">Recommendations for you:</h2>
<?php
$email = $_SESSION['email'];
$now = new DateTime();

    $sql = "SELECT * FROM auction1 WHERE auctionId IN 
                             (SELECT DISTINCT auctionId from bid where email in 
                            (SELECT email from bid where auctionId in 
                            (SELECT auctionId FROM `bid` WHERE email='$email')) and auctionId not in 
                            (SELECT auctionId FROM `bid` WHERE email='$email'));";
    $result = mysqli_query($con, $sql);
    $check = mysqli_num_rows($result);

    if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    $item_id = $row['auctionId'];
    $title = $row["title"];
    $description = $row["details"];
    $num_bids = $row["num_bids"];
    $db_email = $row["email"];
    if ($num_bids==0){
        $current_price = $row["startingPrice"];
    }
    else {
            $current_price = $row["reservePrice"];
        }
    $end_date = new DateTime($row["endDate"]);
    if ($now < $end_date) {
        print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);}}}

