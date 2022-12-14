
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
                // File upload path


                $image = $_FILES["file"];
                $imageFileName = $image['name'];
                $imageFileTemp = $image['tmp_name'];
                $imageSize = $image['size'];
                $fileNameSeperate = explode('.',$imageFileName);
                $file_extension =strtolower($fileNameSeperate[1]);
                $extensions = array('jpg','png','jpeg');

                $sec = strtotime($endDate);
                $end_Date = date ("Y-m-d h:i", $sec);
                //checking that the required fields are not empty.
                if (!empty($auctionTitle) && !empty($auctionDetails) && !empty($category) && !empty($startPrice) && !empty($image) && !empty($endDate)) {
                    //checking that the start price is not 0 as it won't make sense.
                    if ($startPrice!=0) {
                        //checking that reserve price is an integer or is left empty.
                        if (is_int($reservePrice) or $reservePrice=='' or $reservePrice > $startPrice) {
                            //checking that end date&time entered by the user is later than the current date&time.

                            if (in_array($file_extension,$extensions)) {
                                $upload_images = "images/".$imageFileName;
                                move_uploaded_file($imageFileTemp,$upload_images);
                                if ($end_Date > $dateNow) {
                                      //auto incrementing the auctionID by 1, if it is the first entry then auctionID is set to 1.
                                    $query = ("select * from auction1 order by auctionId desc limit 1");
                                    $result = mysqli_query($con, $query);
                                    $row = mysqli_fetch_array($result);
                                    $greaterAuctionId = $row['auctionId'];
                                    if ($greaterAuctionId == '') {
                                        $auctionID = '1';
                                    } else {
                                        $auctionID = $greaterAuctionId + 1;
                                    }
//                                      inserting form data in the database.
                                    $sql = ("INSERT INTO auction1 (auctionID,email, title, details, category, startingPrice, reservePrice, endDate, image) VALUES ('$auctionID','$email', '$auctionTitle','$auctionDetails','$category','$startPrice','$reservePrice','$end_Date', '$upload_images')");
                                    $result = $con->query($sql);
                                    //informing user that auction was created successfully if all okay.
                                    if ($result) {
                                        echo('<div class="text-center">Auction successfully created! <a href="mylistings.php">View your new listing.</a></div>');
                                    } else {
                                        echo "Form not submitted";
                                    }
                                      //useful error messages to the use depending on what is wrong when completing the form.
                                } elseif ($end_Date <= $dateNow) {
                                      echo "End Date should be anytime later than today";
                                  } else {
                                      echo "End Date should be in a valid date form";
                                  }
                            }else{
                                echo 'Sorry something went wrong with uploading the image';
                            }
                        } else {
                            echo "Reserve Price should be a entered as a number or decimal and definitely bigger than starting price.";
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
