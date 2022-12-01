<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include("connection.php")?>

<div class="container">

    <h2 class="my-3">Browse listings</h2>
    <div id="searchSpecs">
        <!-- When this form is submitted, this PHP page is what processes it.
             Search/sort specs are passed to this page through parameters in the URL
             (GET method of passing data to a page). -->
        <form method="get" action="browse.php">
            <div class="row">
                <div class="col-md-5 pr-0">
                    <div class="form-group">
                        <label for="keyword" class="sr-only">Search keyword:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">

            <span class="input-group-text bg-transparent pr-0 text-muted">
              <i class="fa fa-search"></i>
            </span>
                                </div>
                                <input type="text" class="form-control border-left-0" id="keyword" name="keyword" placeholder="Search for anything">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pr-0">
                        <div class="form-group">
                            <label for="cat" class="sr-only">Search within:</label>
                            <select class="form-control" name = "cat" id="cat">
                                <option selected value="all">All categories</option>
                                <option value="fashion">Fashion</option>
                                <option value="healthBeauty">Health & Beauty</option>
                                <option value="electronics">Electronics</option>
                                <option value="homeGarden">Home & Garden</option>
                                <option value="hobbiesLeisure">Hobbies & Leisure</option>
                                <option value="media">Media</option>
                                <option value="art">Art</option>
                                <option value="sports">Sports</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 pr-0">
                        <div class="form-inline">
                            <label class="mx-2"  for="order_by">Sort by:</label>
                            <select class="form-control" name ="order_by" id="order_by">
                                <option selected value="noOrder">No order</option>
                                <option value="pricelow">Price (low to high)</option>
                                <option value="pricehigh">Price (high to low)</option>
                                <option value="date">Soonest expiry</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 px-0">
                        <button type="submit" class="btn btn-primary" name = 'search'>Search</button>
                    </div>
                </div>
            </form>
        </div> <!-- end search specs bar -->


    </div>

<?php


// define behaviour when browse.php is empty and when its not
if (!isset($_GET['keyword'])){
    $keyword = '';
}
else{
    $keyword = $_GET['keyword'];
}
if (!isset($_GET['cat'])){
    $category = 'all';
}
else{
    $category = $_GET['cat'];
}
if (!isset($_GET['order_by'])){
    $ordering = 'noOrder';
}
else{
    $ordering = $_GET['order_by'];
    if ($ordering == 'pricelow'){
        $orderVar = "startingPrice ASC";
    }
    elseif ($ordering == 'pricehigh'){
        $orderVar = "startingPrice DESC";
    }
    elseif ($ordering == 'else'){
        $orderVar = "endDate ASC";
    }
}



if (!isset($_GET['page'])) {
    $curr_page = 1;
}
else {
    $curr_page = $_GET['page'];
}


// make queries
/* TODO: Use above values to construct a query. Use this query to
   retrieve data from the database. (If there is no form data entered,
   decide on appropriate default value/default query to make. */
if ($category != 'all'){
    $sql = "SELECT * FROM auction1 WHERE category = '$category' INTERSECT SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY @orderVar";

//    if ($ordering == 'pricelow'){
//        $sql = "SELECT * FROM auction1 WHERE category = '$category' INTERSECT SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY startingPrice ASC";}
//    if ($ordering == 'pricehigh'){
//        $sql = "SELECT * FROM auction1 WHERE category = '$category' INTERSECT SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY startingPrice DESC";}
//    if ($ordering == 'else'){
//        $sql = "SELECT * FROM auction1 WHERE category = '$category' INTERSECT SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY endDate ASC";}
    $result = mysqli_query($con,$sql);

}

elseif ($category == 'all') {
    $sql = "SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%'";
    if ($ordering == 'pricelow'){
        $sql = "SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY startingPrice ASC";}
    if ($ordering == 'pricehigh'){
        $sql = "SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY startingPrice DESC";}
    if ($ordering == 'else'){
        $sql = "SELECT * FROM auction1 WHERE title LIKE '%$keyword%' OR details LIKE '%$keyword%' ORDER BY endDate ASC";
    }
    $result = mysqli_query($con,$sql);

}



/* TODO: Use above values to construct a query. Use this query to
   retrieve data from the database. (If there is no form data entered,
   decide on appropriate default value/default query to make. */




/* For the purposes of pagination, it would also be helpful to know the
   total number of results that satisfy the above query */



$results_per_page = 10;
//find the initial page number
$initial_page = ($curr_page-1) * $results_per_page;
$total_pages_sql = "SELECT COUNT(*) FROM auction1";
$result = mysqli_query($con,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$max_page = ceil($total_rows / $results_per_page);

$offset = $initial_page . ',' . $results_per_page;
$sql = $sql.'LIMIT '.$offset;
$result = mysqli_query($con,$sql);

?>

    <div class="container mt-5">

        <!-- TODO: If result set is empty, print an informative message. Otherwise... -->
        <?php
        if ($result->num_rows == 0) {
            // output data of each row
            print 'No results found';
        }
        ?>
        <ul class="list-group">

            <!-- TODO: Use a while loop to print a list item for each auction listing
                 retrieved from the query -->
            <?php
            //while loop to print the result
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $item_id = $row["auctionId"];
                    $title = $row["title"];
                    $description = $row["details"];
                    $current_price = $row["startingPrice"];
                    $num_bids = 1;
                    $end_date = new DateTime($row["endDate"]);
                    $image = $row["image"];
                    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date,$image);
                }
            }
            ?>
        </ul>

        <!-- Pagination for results listings -->
        <nav aria-label="Search results pages" class="mt-5">
            <ul class="pagination justify-content-center">

                <?php

                // Copy any currently-set GET variables to the URL.
                $querystring = "";
                foreach ($_GET as $key => $value) {
                    if ($key != "page") {
                        $querystring .= "$key=$value&amp;";
                    }
                }

                $high_page_boost = max(3 - $curr_page, 0);
                $low_page_boost = max(2 - ($max_page - $curr_page), 0);
                $low_page = max(1, $curr_page - 2 - $low_page_boost);
                $high_page = min($max_page, $curr_page + 2 + $high_page_boost);

                if ($curr_page != 1) {
                    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
        <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
    </li>');
                }

                for ($i = $low_page; $i <= $high_page; $i++) {
                    if ($i == $curr_page) {
                        // Highlight the link
                        echo('
    <li class="page-item active">');
                    }
                    else {
                        // Non-highlighted link
                        echo('
    <li class="page-item">');
                    }

                    // Do this in any case
                    echo('
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
                }

                if ($curr_page != $max_page) {
                    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
                }
                ?>

            </ul>
        </nav>


    </div>



<?php include_once("footer.php")?>
