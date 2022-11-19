<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>

    <div class="container">

                <h2 class="my-3">Recommendations for you</h2>
<?php
$email = $_SESSION['email'];
$now = new DateTime();

//display items which have highest number of bids from last week
$sql = "SELECT * from auction1 INNER JOIN
(SELECT auctionId, COUNT(*) AS c FROM bid WHERE date BETWEEN date_sub(now(),INTERVAL 1 WEEK) AND now() GROUP BY auctionId) AS c_table
WHERE auction1.auctionId = c_table.auctionId ORDER BY c DESC LIMIT 3;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
//only print if such items exist
if ($check >0) {
    ?>
    <h4 class="my-3">Trending this week</h4>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
                $item_id = $row['auctionId'];
                $title = $row["title"];
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
                if ($end_date > $now) {
                print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
                }
    }
}

$sql = "SELECT DISTINCT category FROM auction1;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check>0) {
    while ($row = mysqli_fetch_assoc($result)){
        $category = $row['category'];
        $sql2 = "SELECT * FROM auction1 WHERE auctionId IN( 
        SELECT auctionId FROM bid WHERE email IN( 
        SELECT email FROM bid WHERE auctionId IN ( 
        SELECT auctionId FROM bid WHERE email = '$email'))) 
        AND auctionId NOT IN ( 
        SELECT auctionId FROM bid WHERE email = '$email') 
        AND endDate>now();";
        $result2 = mysqli_query($con, $sql2);
        $check2 = mysqli_num_rows($result2);
        if ($check2>0) {
            while ($row = mysqli_fetch_assoc($result2)) {
                $item_id = $row['auctionId'];
                $title = $row["title"];
                $description = $row["details"];
                $num_bids = $row["num_bids"];
                $e_mail = $row['email'];
                $category_item = $row['category'];
                if ($num_bids==0){
                    $current_price = $row["startingPrice"];
                }
                else {
                    $current_price = $row["reservePrice"];
                }
                $end_date = new DateTime($row["endDate"]);
                if ($category == $category_item) {
                    ?> <h4 class="my-3">More in <?php echo $category?>:</h4><?php
                    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);

                }
    }
}}}