<?php include('connection.php');
include_once("header.php");
require("utilities.php") ;

$email = $_SESSION['email'];
$item_id = $_GET['item_id'];
$bid = $_GET['my_bid'];
$sql = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);

if ($check>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $current_price = $row['reservePrice'];
    }
}

if ($bid > $current_price) {
    $sql1 = "UPDATE auction1 SET reservePrice = $bid, num_bids = num_bids + 1 WHERE auctionId = $item_id;";
    $result1 = mysqli_query($con, $sql1);

    $sql2 = "SELECT * FROM bid WHERE auctionId = $item_id AND email = '$email';";
    $result2 = mysqli_query($con, $sql2);
    $check2 = mysqli_num_rows($result2);

    if ($check2 > 0) {
        $sql3 = "UPDATE bid SET price = $bid, date = now() WHERE auctionId = $item_id AND email = '$email';";
        $result3 = mysqli_query($con, $sql3);
        echo "Bid successful!";
        header("refresh:3; mybids.php");
    }
    else {
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
        echo "Bid successful! $title has been added to My Bids.";
        header("refresh:3; mybids.php");
    }



}
else {
    echo "Bid value too low.";
    ?>
    <form>
        <input type="button" value="Return to listing" onClick="javascript:history.go(-1)" />
    </form>
<?php } ?>

<?php
// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.*/
?>