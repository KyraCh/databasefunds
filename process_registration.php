<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation
// options.

//session_start();

include("connection.php");



if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $fist_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $password_1 = $_POST['password'];
    $password_2 = $_POST['password2'];
    $role = $_POST['accountType'];

    if(!empty($email) && !empty($password_1) && !empty($fist_name) && !empty($last_name) && !is_numeric($email))
    {


        $hash = password_hash($password_1, PASSWORD_DEFAULT);
        $query = "insert into users (email,password,firstName,lastName,role) values ('$email','$password_1','$fist_name','$last_name','$role')";

        mysqli_query($con, $query);


        echo "<script>alert('Customer Registration done successfully..');</script>";
        echo "<script>window.location='browse.php';</script>";

        die;
    }else
    {
        echo "Information not valid.";
    }
}
?>
