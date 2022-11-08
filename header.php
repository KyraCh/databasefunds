<?php
// FIXME: At the moment, I've allowed these values to be set manually.
// But eventually, with a database, these should be set automatically
// ONLY after the user's login credentials have been verified via a
// database query.
#comment
session_start();
//*added this if statement here to change the session to the user's session after login, this allows for each login to belong to one user
if(isset($_POST['submit']))
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
    else
    {
        $_SESSION['logged_in'] = false;
        echo "<script>alert('Failed to login...');</script>";
        "<script>window.location='index.php';</script>";
    }
}

//$_SESSION['logged_in'] = false;
//$_SESSION['account_type'] = 'seller';
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
                <form method="POST" action="login_result.php">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name= "email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name = "password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary form-control" name="submit">Sign in</button>
                </form>
                <div class="text-center">or <a href="register.php">create an account</a></div>
            </div>

        </div>
    </div>
</div> <!-- End modal -->