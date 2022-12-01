<?php include_once("header.php")?>
<?php include_once("login_result.php")?>


    <div class="container">
        <h2 class="my-3">Login to your account</h2>
        <!-- Create auction form -->
        <form action="" method="post"  onsubmit="return errors()">
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
                <div class="col-sm-10">
                    <input type="text" name = "email" class="form-control" id="email" placeholder="Email">
                    <small  class="form-text text-muted"><span class="errormsg text-danger" id="emailHelp"></span></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label text-right">Password</label>
                <div class="col-sm-10">
                    <input type="password" name = "password" class="form-control" id="password" placeholder="Password">
                    <small class="form-text text-muted"><span class="errormsg text-danger"  id="passwordHelp" ></span></small>
                </div>
            </div>
            <div   class="form-group row">
                <button type="submit" class="btn btn-primary form-control"  name="loginSubmit">Login</button>
            </div>
        </form>
    </div>

<?php include_once("footer.php")?>

<script>
    function errors()
    {

        var emailErr = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        $('.errormsg').html('');
        var errchk = "False";

        // why is my check here not working?
        if(document.getElementById("email").value === "")
        {
            document.getElementById("emailHelp").innerHTML="Email is empty.";
            errchk = "True";
        }
        if(!document.getElementById("email").value.match(emailErr))
        {
            document.getElementById("emailHelp").innerHTML = "Invalid email format.";
            errchk = "True";
        }
        // why is my check here not working?
        if(document.getElementById("password").value === "")
        {
            document.getElementById("passwordHelp").innerHTML="Password is empty.";
            errchk = "True";
        }
        if(document.getElementById("password").value.length < 8)
        {
            document.getElementById("passwordHelp").innerHTML ="Password should be 8 characters or more.";
            errchk = "True";
        }

        return errchk !== "True";
    }
</script>

