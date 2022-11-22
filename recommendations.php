<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>

    <div class="container">
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

//recommendations based on collaborative filtering for each item user bid on (3 most recent)
$sql = "SELECT DISTINCT title, auction1.auctionId FROM auction1 
INNER JOIN bid 
WHERE auction1.auctionId = bid.auctionId
AND bid.email = '$email' 
ORDER BY date DESC
LIMIT 3;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check>0){
    while ($row = mysqli_fetch_assoc($result)){
        $item_id_bid = $row['auctionId'];
        $title_bid = $row['title'];
        $sql_rec = "SELECT * FROM auction1 
WHERE auctionId IN
(SELECT DISTINCT auctionId FROM bid 
WHERE email IN
(SELECT email FROM bid WHERE auctionId = $item_id_bid)
AND email != '$email')
AND auctionId NOT IN
(SELECT auctionId FROM bid
WHERE email = '$email')
LIMIT 3;";
        $result_rec = mysqli_query($con, $sql_rec);
        $check_rec = mysqli_num_rows($result_rec);
        if ($check_rec>0){
            ?>
        <h4 class="my-3">Recommended for you based on <?php echo $title_bid?></h4>
        <?php
        while ($row = mysqli_fetch_assoc($result_rec)){
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
            if ($end_date > $now){
                print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
            }
        }
    }
}
}

//recommendations based on categories of items that user has previously bid on
$sql_cat = "SELECT DISTINCT category FROM auction1
INNER JOIN
(SELECT auctionId, date FROM bid WHERE email = 'bobmu@outlook.com') AS bids
ON auction1.auctionId = bids.auctionId
ORDER BY bids.date
LIMIT 3;";
$result_cat = mysqli_query($con, $sql_cat);
$check_cat = mysqli_num_rows($result_cat);
if ($check_cat>0){
    while ($row = mysqli_fetch_assoc($result_cat)){
            $category = $row['category'];
            $sql_rec_cat = "SELECT DISTINCT title, details, reservePrice, endDate, num_bids, b.auctionId, category FROM auction1 
INNER JOIN bid as b
ON b.auctionId = auction1.auctionId
WHERE category = '$category'
AND b.email != '$email';";
            $result_rec_cat = mysqli_query($con, $sql_rec_cat);
            $check_rec_cat = mysqli_num_rows($result_rec_cat);
            if ($check_rec_cat>0){
                ?>
                <h4 class="my-3">More in <?php echo $category?></h4>
                <?php
                while ($row = mysqli_fetch_assoc($result_rec_cat)){
                    $item_id = $row['auctionId'];
                    $title = $row["title"];
                    $description = $row["details"];
                    $num_bids = $row["num_bids"];
                    if ($num_bids==0){
                        $current_price = $row["startingPrice"];
                    }
                    else {
                        $current_price = $row["reservePrice"];
                    }
                    $end_date = new DateTime($row["endDate"]);
                    if ($end_date > $now){
                        print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
                    }
                }
            }
    }
}

