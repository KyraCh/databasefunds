<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>

    <div class="container">

                <h2 class="my-3">Recommendations for you</h2>
<?php
$email = $_SESSION['email'];
$now = new DateTime();

$sql = "SELECT DISTINCT category FROM auction1;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check>0) {
    while ($row = mysqli_fetch_assoc($result)){
        $category = $row['category'];
        $sql2 = "SELECT * FROM auction1 WHERE auctionId IN( 
        SELECT auctionId FROM bid WHERE email IN( 
        SELECT email FROM bid WHERE auctionId IN ( 
        SELECT auctionId FROM bid WHERE email = 'bobmu@outlook.com'))) 
        AND auctionId NOT IN ( 
        SELECT auctionId FROM bid WHERE email = 'bobmu@outlook.com') 
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
