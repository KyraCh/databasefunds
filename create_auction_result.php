<?php include_once("header.php")?>

<div class="container my-5">

<?php
// This function takes the form data and adds the new auction to the database.

//connects to MySQL database.
include("connection.php");
//connect to create_auction file which is the html file for creating the form.
include("create_auction.php");
//storing current date and time in a variable.
$dateNow = date("Y-m-d h:i");
//calling the email of the user that was logged in previously.
$email = $_SESSION['email'];

//checking if the user is logged in before trying to create an auction.
if($_SESSION['logged_in'] == true) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        //the way we get the data entered by the user in the website.
            $auctionTitle = $_POST['auctionTitle'];
            $auctionDetails = $_POST['auctionDetails'];
            $category = $_POST['category'];
            $startPrice = $_POST['startPrice'];
            $reservePrice = $_POST['reservePrice'];
            $endDate = $_POST['endDate'];
            $sec = strtotime($endDate);
            $endDate = date ("Y-d-m H:i", $sec);
            //checking that the required fields are not empty.
            if (!empty($auctionTitle) && !empty($auctionDetails) && !empty($category) && !empty($startPrice) && !empty($endDate)) {
                //checking that the start price is not 0 as it won't make sense.
                if ($startPrice!=0) {
                    //checking that reserve price is an integer or is left empty.
                    if (is_int($reservePrice) or $reservePrice=='') {
                        //checking that end date&time entered by the user is later than the current date&time.
                        if ($endDate > $dateNow) {
                            //auto incrementing the auctionID by 1, if it is the first entry then auctionID is set to 1.
                            $query=("select * from auction1 order by auctionId desc limit 1");
                            $result=mysqli_query($con,$query);
                            $row=mysqli_fetch_array($result);
                            $greaterAuctionId=$row['auctionId'];
                            if ($greaterAuctionId==''){
                                $auctionID='1';
                            }
                            else{
                                $auctionID= $greaterAuctionId + 1;
                            }
                            //inserting form data in the database.
                            $sql =("INSERT INTO auction1 (auctionID,email, title, details, category, startingPrice, reservePrice, endDate) VALUES ('$auctionID','$email', '$auctionTitle','$auctionDetails','$category','$startPrice','$reservePrice','$endDate')");
                            $result = $con->query($sql);
                            //informing user that auction was created successfully if all okay.
                            if ($result){
                                echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');
                            }
                            else {
                                echo "Form not submitted";
                            }
                        //useful error messages to the use depending on what is wrong when compeleting the form.
                        } elseif ($endDate <= $dateNow) {
                            echo "End Date should be anytime later than today";
                        } else {
                            echo "End Date should be in a valid date form";
                        }
                    } else {
                        echo "Reserve Price should be a entered as a number or decimal.";
                    }
                } else {
                    echo "Starting Price should not be equal to 0.";
                }
            } else {
                echo "You need to fill in all required fields.";
            }
    }
} else {
    echo "You need to be logged in to create an auction.";
}


?>

</div>


<?php include_once("footer.php")?>
