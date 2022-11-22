<?php include_once("header.php")?>
<?php include_once("login_result.php")?>


<div class="container">
    <h2 class="my-3">Login to your new account</h2>
    <!-- Create auction form -->
    <form method="POST" action="login_result.php">
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
            <div class="col-sm-10">
                <input type="text" name = "email" class="form-control" id="email" placeholder="Email">
                <small id="emailHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label text-right">Password</label>
            <div class="col-sm-10">
                <input type="password" name = "password" class="form-control" id="password" placeholder="Password">
                <small id="passwordHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
            </div>
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-primary form-control">Login</button>
        </div>
    </form>
    </div>

    <?php include_once("footer.php")?>
