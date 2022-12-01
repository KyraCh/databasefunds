<?php include("header.php"); ?>
<?php include("process_registration.php")?>


<div class="container">
    <h2 class="my-3">Register new account</h2>
        <form action="" method="post"  onsubmit="return errors()">
            <div class="form-group row">
                <label for="accountType" class="col-sm-2 col-form-label text-right">Registering as a:</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="accountType" id="accountBuyer" value="buyer" checked>
                        <label class="form-check-label" for="accountBuyer">Buyer</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="accountType" id="accountSeller" value="seller">
                        <label class="form-check-label" for="accountSeller">Seller</label>
                    </div>
                    <small id="accountTypeHelp" class="form-text-inline text-muted"><span class="text-danger">* Required.</span></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="firstName" class="col-sm-2 col-form-label text-right">First Name</label>
                <div class="col-sm-10">
                    <input type="text" name = "firstName" class="form-control" id="firstName" placeholder="First Name">
                    <small  class="required"><span class="errormsg text-danger" id="firstNameHelp">* Required.</span></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="lastName" class="col-sm-2 col-form-label text-right">Last Name</label>
                <div class="col-sm-10">
                    <input type="text" name = "lastName" class="form-control" id="lastName" placeholder="Last Name">
                    <small  class="form-text text-muted"><span class="errormsg text-danger" id="lastNameHelp">* Required.</span></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
                <div class="col-sm-10">
                    <input type="text" name = "email" class="form-control" id="email_id" placeholder="Email">
                    <small class="form-text text-muted"><span class="errormsg text-danger"  id="emailHelp">* Required.</span></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label text-right">Password</label>
                <div class="col-sm-10">
                    <input type="password" name = "password" class="form-control" id="password_id" placeholder="Password">
                    <small  class="form-text text-muted"><span class="errormsg text-danger" id="passwordHelp">* Required.</span></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="passwordConfirmation" class="col-sm-2 col-form-label text-right">Repeat password</label>
                <div class="col-sm-10">
                    <input type="password" name="password2" class="form-control" id="passwordConfirmation" placeholder="Enter password again">
                    <small  class="form-text text-muted"><span class="errormsg text-danger" id="passwordConfirmationHelp">* Required.</span></small>
                </div>
            </div>
            <div class="clear"></div>
            <div class="form-group row">
                <button type="submit" name='submit' class="btn btn-primary form-control">Register</button>
            </div>
        </form>
        <div class="text-center">Already have an account? <a href="login.php">Login</a>
</div>

<?php
include("footer.php");
?>


<script>
    function errors()
    {
        var alphaSpaceErr = /^[a-zA-Z\s]+$/;
        var emailErr = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        $('.errormsg').html('');
        var errchk = "False";

        if(document.getElementById("firstName").value.length > 40)
        {
            document.getElementById("firstNameHelp").innerHTML="First Name is too long.";
            errchk = "True";
        }
        if(!document.getElementById("firstName").value.match(alphaSpaceErr))
        {
            document.getElementById("firstNameHelp").innerHTML = "Invalid First Name.";
            errchk = "True";
        }
        if(document.getElementById("firstName").value === "")
        {
            document.getElementById("firstNameHelp").innerHTML="First Name cannot be empty.";
            errchk = "True";
        }

        if(document.getElementById("lastName").value.length > 40)
        {
            document.getElementById("firstNameHelp").innerHTML="Last Name is too long.";
            errchk = "True";
        }

        if(!document.getElementById("lastName").value.match(alphaSpaceErr))
        {
            document.getElementById("lastNameHelp").innerHTML = "Invalid First Name.";
            errchk = "True";
        }
        if(document.getElementById("lastName").value === "")
        {
            document.getElementById("lastNameHelp").innerHTML="First Name cannot be empty.";
            errchk = "True";
        }

        if(document.getElementById("email_id").value.length > 320)
        {
            document.getElementById("firstNameHelp").innerHTML="Email is too long";
            errchk = "True";
        }


        if(!document.getElementById("email_id").value.match(emailErr))
        {
            document.getElementById("emailHelp").innerHTML = "Invalid email.";
            errchk = "True";
        }
        if(document.getElementById("email_id").value === "")
        {
            document.getElementById("emailHelp").innerHTML="Email cannot be empty.";
            errchk = "True";
        }


        if(document.getElementById("password_id").value.length < 8)
        {
            document.getElementById("passwordHelp").innerHTML ="Password should be 8 characters or more.";
            errchk = "True";
        }
        if(document.getElementById("password_id").value.length > 16)
        {
            document.getElementById("passwordHelp").innerHTML ="Password should be less than 16 characters.";
            errchk = "True";
        }
        if(document.getElementById("password_id").value === "")
        {
            document.getElementById("passwordHelp").innerHTML ="Password cannot be empty.";
            errchk = "True";
        }

        if(document.getElementById("passwordConfirmation").value !== document.getElementById("password_id").value )
        {
            document.getElementById("passwordConfirmationHelp").innerHTML ="Passwords do not match.";
            errchk = "True";
        }
        if(document.getElementById("passwordConfirmation").value === "")
        {
            document.getElementById("passwordConfirmationHelp").innerHTML ="Repeat Password cannot be empty.";
            i=1;
        }
        return errchk !== "True";
    }
</script>
