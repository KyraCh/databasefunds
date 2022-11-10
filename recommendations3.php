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
        $item_id = $row['auctionId'];?>
        <?php
        $sql2 = "SELECT * FROM auction1 where auctionId in
                (SELECT DISTINCT auctionId from bid where email in 
                (SELECT email FROM `bid` WHERE auctionId = $item_id and email != '$email') and auctionId not in (SELECT auctionId FROM bid where email = '$email'));";
        $result2 = mysqli_query($con, $sql2);
        $check2 = mysqli_num_rows($result2);
        if ($check2>0) {
            ?><h4 class="my-3">Others who bid on <?php echo $title?> have also bid on:</h4><?php
            while ($row = mysqli_fetch_assoc($result2)) {
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
                if ($now < $end_date) {
                    print_listing_li($item_id2, $title2, $description, $current_price, $num_bids, $end_date);}}}}}
