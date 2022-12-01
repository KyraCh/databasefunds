<?php
// FIXME: At the moment, I've allowed these values to be set manually.
// But eventually, with a database, these should be set automatically
// ONLY after the user's login credentials have been verified via a

//session_start();

include('connection.php');
include('login_result.php');

if(isset($_POST['loginSubmit']))

{

    $sql= "SELECT * FROM users WHERE email='$_POST[email]' AND password='$_POST[password]'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) == 1 )
    {

        $user_data= mysqli_fetch_array($result);
        $_SESSION["email"] = $user_data['email'];
        $_SESSION['account_type'] = $user_data['role'];
        $_SESSION['logged_in'] = true;
        "<script>window.location='index.php';</script>";
    }
   else{
       $_SESSION['logged_in'] = false;
   }
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap and FontAwesome CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS file -->
    <link rel="stylesheet" href="css/custom.css">

    <title>[My Auction Site] <!--CHANGEME!--></title>
</head>


<body>

<!-- Navbars -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mx-2">
    <a class="navbar-brand" href="#">Site Name <!--CHANGEME!--></a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">

            <?php
            // Displays either login or logout on the right, depending on user's
            // current status (session).
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                echo '<a class="nav-link" href="logout.php">Logout</a>';
            }
            else {
                echo '<button type="button" class="btn nav-link" data-toggle="modal" data-target="#loginModal">Login</button>';
            }
            ?>

        </li>
    </ul>
</nav>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav align-middle">
        <li class="nav-item mx-1">
            <a class="nav-link" href="browse.php">Browse</a>
        </li>
        <?php
        if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'buyer') {
            echo('
	<li class="nav-item mx-1">
      <a class="nav-link" href="mybids.php">My Bids</a>
    </li>
	<li class="nav-item mx-1">
      <a class="nav-link" href="recommendations.php">Recommended</a>
    </li>');
        }
        if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'seller') {
            echo('
	<li class="nav-item mx-1">
      <a class="nav-link" href="mylistings.php">My Listings</a>
    </li>
	<li class="nav-item ml-3">
      <a class="nav-link btn border-light" href="create_auction.php">+ Create auction</a>
    </li>');
        }
        ?>
    </ul>
</nav>

<!-- Login modal -->
<div class="modal fade" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="" method="post"  onsubmit="return errors()">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name= "email" class="form-control" id="email" placeholder="Email">
                        <small  class="required"><span class="errormsg text-danger" id="emailhelp"></span></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name = "password" class="form-control" id="password" placeholder="Password">
                        <small  class="required"><span class="errormsg text-danger" id="passwordhelp"></span></small>
                    </div>
                    <button href="login_result.php" type="submit" class="btn btn-primary form-control" name="loginSubmit" >Sign in</button>
                </form>
                <div class="text-center">or <a href="register.php">create an account</a></div>
            </div>

        </div>
    </div>
</div> <!-- End modal -->



<script>
    function errors()
    {

        var emailErr = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        $('.errormsg').html('');
        var errchk = "False";

        // why is my check here not working?
        if(document.getElementById("email").value === "")
        {
            document.getElementById("emailhelp").innerHTML="Email is empty.";
            errchk = "True";
        }
        if(!document.getElementById("email").value.match(emailErr))
        {
            document.getElementById("emailhelp").innerHTML = "Invalid email format.";
            errchk = "True";
        }
        // why is my check here not working?
        if(document.getElementById("password").value === "")
        {
            document.getElementById("passwordhelp").innerHTML="Password is empty.";
            errchk = "True";
        }
        if(document.getElementById("password").value.length < 8)
        {
            document.getElementById("passwordhelp").innerHTML ="Password should be 8 characters or more.";
            errchk = "True";
        }


        return errchk !== "True";
    }
</script>
