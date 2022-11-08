<?php include('connection.php');
$item_id = $_GET['item_id'];
$bid = $_GET['my_bid'];
$timestamp = time();
$sql = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);

if ($check>0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $current_price = $row['reservePrice'];
    }
}

if ($bid > $current_price) {
    $sql1 = "UPDATE auction1 SET reservePrice = " . $bid . ", num_bids = num_bids + 1 WHERE auctionId = $item_id;";
    $result1 = mysqli_query($con, $sql1);

    $sql2 = "SELECT * FROM `bid` WHERE auctionId = $item_id AND email = 'cakeandfade@hotmail.co';";
    $result2 = mysqli_query($con, $sql2);
    $check2 = mysqli_num_rows($result2);

    if ($check > 0){
        $sql3 = "UPDATE bid SET price = " . $bid . " WHERE auctionId = $item_id AND email = 'cakeandfade@hotmail.co';";
        $result3 = mysqli_query($con, $sql3);
    }
    else if ($check == 0) {
        $sql3 = "INSERT INTO bid VALUES ($item_id, 'cakeandfade@hotmail.co', $bid, $timestamp);";
        $result3 = mysqli_query($con, $sql3);
    };
    echo "Bid successful!";
    header("refresh:3; mylistings.php");

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