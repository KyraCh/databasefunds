<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php");
if($_SESSION['logged_in'] == 1){
$email = $_SESSION['email'];
$item_id = $_GET['item_id'];
//retrieve information about the item from the database
$sql = "SELECT * FROM  auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row["title"];
        $description = $row["details"];
        $num_bids = $row['num_bids'];
        $image = $row['image'] ;
        echo "<img src='images/".$image."'>";
        if ($num_bids == 0) {
            $current_price = $row["startingPrice"];
        } else {
            $current_price = $row["reservePrice"];
        }
        $end_time = new DateTime($row["endDate"]);
    }//end of while loop
}//end of sql if statement
//retrieve buy now price from the database
$sql = "SELECT * FROM auction1 WHERE auctionId = $item_id;";
$result = mysqli_query($con, $sql);
$check = mysqli_num_rows($result);
if ($check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $buyNowPrice = $row["buyNowPrice"];
    }//end of while loop
}//end of sql if statement

//save current date and time in a variable
$now = new DateTime();
//check if auction is still active and if so, display time remaining
if ($now < $end_time) {
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = ' (in ' . display_time_remaining($time_to_end) . ')';
}

// TODO: If the user has a session, use it to make a query to the database
//       to determine if the user is already watching this item.
//       For now, this is hardcoded.
$has_session = true;
$watching = false;


}else{
$_SESSION['logged_in'] = false;

echo('<div class="text-center">You have to have an account to view this item <a href="register.php">Register here</a></div>');
}
?>
<div class="container">

    <div class="row"> <!-- Row #1 with auction title + watch button -->
        <div class="col-sm-8"> <!-- Left col -->
            <h2 class="my-3"><?php echo($title); ?></h2>
        </div>
        <div class="col-sm-4 align-self-center"> <!-- Right col -->
            <?php
            /* The following watchlist functionality uses JavaScript, but could
               just as easily use PHP as in other places in the code */
            if ($now < $end_time):
                ?>
                <div id="watch_nowatch" <?php if ($has_session && $watching) echo('style="display: none"');?> >
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToWatchlist()">+ Add to watchlist</button>
                </div>
                <div id="watch_watching" <?php if (!$has_session || !$watching) echo('style="display: none"');?> >
                    <button type="button" class="btn btn-success btn-sm" disabled>Watching</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFromWatchlist()">Remove watch</button>
                </div>
            <?php endif /* Print nothing otherwise */ ?>
        </div>
    </div>

    <div class="row"> <!-- Row #2 with auction description + bidding info -->
        <div class="col-sm-8"> <!-- Left col with item info -->

            <div class="itemDescription">
                <?php echo($description); ?>
            </div>

        </div>

        <div class="col-sm-4"> <!-- Right col with bidding info -->

            <p>
                <?php if ($now > $end_time): ?>
                    This auction ended <?php echo(date_format($end_time, 'j M H:i')) ?>
                    <!-- TODO: Print the result of the auction here? -->
                <?php else: ?>
                Auction ends <?php echo(date_format($end_time, 'j M H:i') . $time_remaining) ?></p>
            <p class="lead">Current bid: £<?php echo(number_format($current_price, 2)) ?></p>

            <!-- Bidding form -->
            <?php //check if the current user has a buyer type account ?>
            <?php if ($_SESSION["account_type"]=="buyer") {
                //only display 'buy now' option if it is lower than the current highest bid
                if ($buyNowPrice>$current_price) {
                    ?>
                    <form method="GET" action="place_bid.php">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">£</span>
                            </div>
                            <input type= "hidden" name = "item_id" id = "item_id" value = "<?php $item_id = $_GET["item_id"]; echo "$item_id"; ?>">
                            <input type="number" name="my_bid"  class="form-control" id="bid">
                            <button type="submit" name="PlaceBid" class="btn btn-secondary form-control">Place bid</button>
                        </div>
                        <button type="submit" name="BuyNow" class="btn btn-primary form-control">Buy now for £<?echo $buyNowPrice?></button>
                    </form>
                <?php }
                //otherwise only give the user the option to place a higher bid
                else {
                    ?>
                    <form method="GET" action="place_bid.php">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">£</span>
                            </div>
                            <input type= "hidden" name = "item_id" id = "item_id" value = "<?php $item_id = $_GET["item_id"]; echo "$item_id"; ?>">
                            <input type="number" name="my_bid"  class="form-control" id="bid">
                        </div>
                        <button type="submit" name = "PlaceBid" class="btn btn-primary form-control">Place bid</button>
                    </form>
                    <?php
                }
            }
            endif ?>


        </div> <!-- End of right col with bidding info -->

    </div> <!-- End of row #2 -->


    <?php include_once("footer.php")?>


    <script>
        // JavaScript functions: addToWatchlist and removeFromWatchlist.

        function addToWatchlist(button) {
            console.log("These print statements are helpful for debugging btw");

            // This performs an asynchronous call to a PHP function using POST method.
            // Sends item ID as an argument to that function.
            $.ajax('watchlist_funcs.php', {
                type: "POST",
                data: {functionname: 'add_to_watchlist', arguments: [<?php echo($item_id);?>]},

                success:
                    function (obj, textstatus) {
                        // Callback function for when call is successful and returns obj
                        console.log("Success");
                        var objT = obj.trim();

                        if (objT == "success") {
                            $("#watch_nowatch").hide();
                            $("#watch_watching").show();
                        }
                        else {
                            var mydiv = document.getElementById("watch_nowatch");
                            mydiv.appendChild(document.createElement("br"));
                            mydiv.appendChild(document.createTextNode("Add to watch failed. Try again later."));
                        }
                    },

                error:
                    function (obj, textstatus) {
                        console.log("Error");
                    }
            }); // End of AJAX call

        } // End of addToWatchlist func

        function removeFromWatchlist(button) {
            // This performs an asynchronous call to a PHP function using POST method.
            // Sends item ID as an argument to that function.
            $.ajax('watchlist_funcs.php', {
                type: "POST",
                data: {functionname: 'remove_from_watchlist', arguments: [<?php echo($item_id);?>]},

                success:
                    function (obj, textstatus) {
                        // Callback function for when call is successful and returns obj
                        console.log("Success");
                        var objT = obj.trim();

                        if (objT == "success") {
                            $("#watch_watching").hide();
                            $("#watch_nowatch").show();
                        }
                        else {
                            var mydiv = document.getElementById("watch_watching");
                            mydiv.appendChild(document.createElement("br"));
                            mydiv.appendChild(document.createTextNode("Watch removal failed. Try again later."));
                        }
                    },

                error:
                    function (obj, textstatus) {
                        console.log("Error");
                    }
            }); // End of AJAX call

        } // End of addToWatchlist func
    </script>
