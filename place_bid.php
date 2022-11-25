<?php include_once("header.php")?>
<?php include('connection.php');
//obtain item id from the URL
$item_id = $_GET['item_id'];
//obtain value of the bid placed
$bid = $_GET['my_bid'];
//obtain buy now price
//retrieve buy now price and current number of bids from the database
$sql = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $buyNowPrice = $row["buyNowPrice"];
        $num_bids = $row["num_bids"];
    }
}
//retrieve current user's email
$email = $_SESSION['email'];
//retrieve current highest bid from the database
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
//check if the user pressed 'place bid' button
if (isset($_GET["PlaceBid"])){
    //check if the bid placed is higher than the current highest bid
    if ($bid > $current_price) {
        //increase num_bids by one in the database
        $sql1 = "UPDATE auction1 SET num_bids = num_bids + 1 WHERE auctionId = $item_id;";
        $result1 = mysqli_query($con, $sql1);
        //check if the user has previously placed a bid on this item
        $sql2 = "SELECT * FROM bid WHERE auctionId = $item_id AND email = '$email';";
        $result2 = mysqli_query($con, $sql2);
        $check2 = mysqli_num_rows($result2);
        //if this user has previously placed a bid on this item, update the price
        if ($check2 > 0) {
            $sql3 = "UPDATE bid SET price = $bid, date = now() WHERE auctionId = $item_id AND email = '$email';";
            $result3 = mysqli_query($con, $sql3);
            echo "Bid successful!";
            header("refresh:3; mybids.php");
        }
    else {
            //if this is the first bid that this user placed on this item, create a row in the bid column
        $sql4 = "INSERT INTO bid VALUES ($item_id, '$email', $bid, now());";
        $result4 = mysqli_query($con, $sql4);
        $sql5 = "SELECT title FROM auction1 WHERE auctionId = $item_id;";
        $result5 = mysqli_query($con, $sql5);
        $check5 = mysqli_num_rows($result5);
        if ($check5>0) {
            while ($row = mysqli_fetch_assoc($result5)) {
                $title = $row['title'];
            }
        }
            //let the user know that their bid was placed
        echo "Bid successful! $title has been added to My Bids.";
        header("refresh:3; mybids.php");
        }}
    else {
        //if the bid is lower than the current highest bid, let the user know
        echo "Bid value too low.";
        ?>
        <form>
            <input type="button" value="Return to listing" onClick="javascript:history.go(-1)" />
        </form>
    <?php }
}
//check if the user pressed the 'buy now' button
if (isset($_GET["BuyNow"])){
    //add buy now row into the bid column
    $sql = "INSERT INTO buy VALUES ($item_id, '$email', now())";
    $result = mysqli_query($con, $sql);
    //end the auction immediately
    $sql2 = "UPDATE auction1 SET endDate = now() WHERE auctionId = $item_id";
    $result2 = mysqli_query($con, $sql2);
    echo "Purchase successful!";
    header("refresh:3; listing.php?item_id=$item_id");
}
?>