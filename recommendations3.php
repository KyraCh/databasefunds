<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>
<div class="container">

<!--        <h2 class="my-3">Recommendations for you:</h2>-->
<?php
$email = $_SESSION['email'];
$now = new DateTime();
//first sql query finds the title and name of items that the users has bid on and orders them by when the bid was placed
$sql = "SELECT * FROM auction1 as a JOIN (SELECT auctionId, date FROM bid WHERE email='$email') as b ON a.auctionId = b.auctionId ORDER BY b.date DESC;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $item_id = $row['auctionId'];
        $sql2 = "SELECT * FROM auction1 where auctionId in
                (SELECT DISTINCT auctionId from bid where email in 
                (SELECT email FROM `bid` WHERE auctionId = $item_id and email != '$email') and auctionId not in (SELECT auctionId FROM bid where email = '$email')) AND endDate>now();";
        $result2 = mysqli_query($con, $sql2);
        $check2 = mysqli_num_rows($result2);
        if ($check2>0) {
            ?><h4 class="my-3">Others who bid on <?php echo $title?> have also bid on:</h4><?php
            if ($row = mysqli_fetch_assoc($result2)) {
                $item_id2 = $row['auctionId'];
                $title2 = $row["title"];
                $description = $row["details"];
                $num_bids = $row["num_bids"];
                $e_mail = $row['email'];
                if ($num_bids==0){
                    $current_price = $row["startingPrice"];
                }
                else {
                    $current_price = $row["reservePrice"];
                }
                $end_date = new DateTime($row["endDate"]);
                print_listing_li($item_id2, $title2, $description, $current_price, $num_bids, $end_date);
                break;
                }}}}

$sql3 = "SELECT DISTINCT bid.email, category FROM bid JOIN auction1 ON auction1.auctionId = bid.auctionId WHERE bid.email = '$email';";
$result3 = mysqli_query($con, $sql3);
$check3 = mysqli_num_rows($result3);
if ($check3>0){
    while ($row = mysqli_fetch_assoc($result3)){
        $category = $row['category'];
        $sql4 = "SELECT * FROM auction1 WHERE category = '$category' AND auctionId NOT IN (SELECT bid.auctionId FROM bid JOIN auction1 ON auction1.auctionId = bid.auctionId WHERE bid.email = '$email') AND endDate>now() ;";
        $result4 = mysqli_query($con, $sql4);
        $check4 = mysqli_num_rows($result4);
        if ($check4>0){
            ?> <h4 class="my-3">More in <?php echo $category?>:</h4><?php
            while ($row = mysqli_fetch_assoc($result4)){
                $item_id3 = $row['auctionId'];
                $title3 = $row["title"];
                $description = $row["details"];
                $num_bids = $row["num_bids"];
                if ($num_bids==0){
                    $current_price = $row["startingPrice"];
                }
                else {
                    $current_price = $row["reservePrice"];
                }
                $end_date = new DateTime($row["endDate"]);
                print_listing_li($item_id3, $title3, $description, $current_price, $num_bids, $end_date);}
            }
        }

}