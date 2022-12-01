<?php include_once("header.php")?>
<?php include('connection.php');
//obtain item id from the URL
$item_id = $_GET['item_id'];
//obtain value of the bid placed
$bid = $_GET['my_bid'];
//obtain buy now price
//retrieve buy now price from the database
$sql = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $buyNowPrice = $row["buyNowPrice"];
    }
}
//retrieve current user's email
$email = $_SESSION['email'];
//retrieve current highest bid from the database
$sql = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $current_price = $row['reservePrice'];
    }
}
//check if the user pressed 'place bid' button
if (isset($_GET["PlaceBid"])){
    //check if the bid placed is higher than the current highest bid
    if ($bid > $current_price) {
        //update the current highest bid in the database
        //increase num_bids by one in the database
        $sql1 = "UPDATE auction1 SET reservePrice = $bid, num_bids = num_bids + 1 WHERE auctionId = $item_id;";
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
        }
    }
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
    $sql = "INSERT INTO bid VALUES ($item_id, '$email', $buyNowPrice, now(), 'buy now')";
    $result = mysqli_query($con, $sql);
    //end the auction immediately and update the current highest bid
    $sql2 = "UPDATE auction1 SET endDate = now(), reservePrice = $buyNowPrice WHERE auctionId = $item_id";
    $result2 = mysqli_query($con, $sql2);
    echo "Purchase successful!";
    header("refresh:3; listing.php?item_id=$item_id");
}
?>
