<?php
// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation
// options.


if(isset($_POST['submit']))
{
    $email = $_POST['email'];
    $sql ="select * from users where email= '$email' limit 1";
    $qsql = mysqli_query($con,$sql);
    if(mysqli_affected_rows($con) == 0){
    $sql ="INSERT INTO users(email,password,firstName,lastName,role) values('" . $_POST['email'] . "','" . $_POST['password'] ."','" . $_POST['firstName'] . "','" . $_POST['lastName'] . "','" . $_POST['accountType'] . "')";
    $qsql = mysqli_query($con,$sql);
    if(mysqli_affected_rows($con) == 1)
    {
        $_SESSION['logged_in'] = true;
        echo "<script>alert('Registration successful.');</script>";
        echo "<script>window.location='login.php';</script>";
    }
    else
    {
        echo "<script>alert('Failed to Register.');</script>";
        echo mysqli_error($con);
    }}
    else{
        echo "<script>alert('An account with this email already exists.');</script>";
    }
}
?>


