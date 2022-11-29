<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation
// options.

//session_start();

if(isset($_POST['submit']))
{
    $sql ="INSERT INTO users(email,password,firstName,lastName,role) values('" . $_POST['email'] . "','" . $_POST['password'] ."','" . $_POST['firstName'] . "','" . $_POST['lastName'] . "','" . $_POST['accountType'] . "')";
    $qsql = mysqli_query($con,$sql);
    if(mysqli_affected_rows($con) == 1)
    {
        $_SESSION['logged_in'] = true;
        echo "<script>alert('Customer Registration done successfully..');</script>";
        echo "<script>window.location='login.php';</script>";
    }
    else
    {
        echo "<script>alert('Failed to Register..');</script>";
        echo mysqli_error($con);
    }
}
?>


