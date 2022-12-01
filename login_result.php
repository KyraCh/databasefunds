<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

session_start();

include("connection.php");



if(isset($_POST['loginSubmit']))
{
    //something was posted
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password) && !is_numeric($email))
    {

        //read from database
        $query = "select * from users where email= '$email' limit 1";
        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {

                $user_data = mysqli_fetch_assoc($result);

                if($user_data['password'] === $password)
                {

                    $_SESSION['email'] = $user_data['email']; //this is now present twice because hers was username
                    $_SESSION['logged_in'] = true;
                    $_SESSION['email'] = $user_data['email']; //this seems to work but should we have used username?
                    $_SESSION['account_type'] = $user_data['role']; //seems to work
                    echo "<script>alert('You are now logged in! You will be redirected shortly.');</script>";
                    // Redirect to index after 5 seconds
                    header("refresh:5;url=index.php");

                    die;
                }
            }
        }
        echo "<script>alert('Failed to login. Wrong username or password.');</script>";
    }else
    {
        echo "<script>alert('Failed to login. Wrong username or password.');</script>";
    }
}



// For now, I will just set session variables and redirect.

//session_start();
//$_SESSION['logged_in'] = true;
//$_SESSION['username'] = "test";
//$_SESSION['account_type'] = "buyer";

//echo('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');
//
//// Redirect to index after 5 seconds
//header("refresh:5;url=index.php");

?>