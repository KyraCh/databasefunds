
<?php include_once("header.php")?>

<div class="container my-5">

<?php

// This function takes the form data and adds the new auction to the database.

/* TODO #1: Connect to MySQL database (perhaps by requiring a file that
            already does this). */


include("connection.php");

$email = $_SESSION["user_id"];
$date_now = date("d-m-y h:i:s");
$query = "select accountType from users where email= '$email' limit 1";
$result = mysqli_query($con,$query);

if($result=="S") {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //something was posted
        $auctionTitle = $_POST["auctionTitle"];
        $auctionDetails = $_POST["auctionDetails"];
        $category = $_POST["category"];
        $startPrice = $_POST["start price"];
        $reservePrice = $_POST["reserve price"];
        $endDate = $_POST["end date"];

        if (!empty($auctionTitle) && !empty($auctionDetails) && !empty($category) && !empty($startPrice) && !empty($endDate) ) {
            $query = "SELECT auctionID FROM auction1";
            $result = mysqli_query($con, max($query));

            if ($result && is_float($startPrice)) {
                if (is_float($reservePrice)) {
                    if ($validDate = date('Y-m-d', strtotime($endDate)) && $endDate > $date_now) {
                        $sql = "INSERT INTO auction1 (auctionID, email, title, details, category, startingPrice, reservePrice, endDate) VALUES ($result+1, $email,  $auctionTitle, $auctionDetails, $category, $startPrice, $reservePrice, $endDate)";
                        $con=exec($sql);
                    } elseif ($endDate <= $date_now) {
                        echo "End Date should be anytime later than today";
                    } else {
                        echo "End Date should be in a valid date form";
                    }
                } else {
                    echo "Reserve Price should be a entered as a number or decimal.";
                }
            } else {
                echo "Start Price should be a entered as a number or decimal.";
            }
        } else {
            echo "You need to fill in all required fields.";
        }
    }
}

/* TODO #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'], 
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */


/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
            

// If all is successful, let user know.
echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');


?>

</div>


<?php include_once("footer.php")?>