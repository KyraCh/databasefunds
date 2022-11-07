<?php include('connection.php');
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
        $sql = "UPDATE auction1 SET reservePrice = " . $bid . ", num_bids = num_bids + 1 WHERE auctionId = $item_id;";
        $result = mysqli_query($con, $sql);
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