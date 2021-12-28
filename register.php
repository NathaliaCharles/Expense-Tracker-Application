<?php
session_start();
require('../new/database/configuration.php');
require('../new/database/database.php');
     if(isset($_SESSION['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
     }

        $query = mysqli_query ($conn,"INSERT INTO registration ('username', 'password', 'repassword') values(?, ?, ?)");
        if ($query) {
            //$message = "you have successfully registered";
        } else { 
            //$message = "please try again";
        }
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register to Expense Tracker</title>
    <link rel="stylesheet" href="../new/css/site.css">
    <link rel="stylesheet" href="../new/css/bootstrap.min.css">
</head>
<body>
    
<!--Registration Form-->
<main>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			    <div class="login-panel panel panel-default">
                    <h1 class="mb-3 mt-3">Register</h1>
                    <form action="" method="POST" onsubmit="return validateRegisterForm()">
                        <div class="form-group">
                            <?php
                            //if ($message) {
                               // echo $message;
                            //}
                            ?>
                        <hr class = "mb-3">
                            <label for="username">Username: </label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Re-Type Password: </label>
                            <input type="password" class="form-control form-control-lg" id="repassword" name="repassword" placeholder="ReType Password" required>
                        </div>
                        <hr class = "mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </form>
                    <p class="pt-3">
                        Already have an account? Log in from 
                        <a href="./login.php">here.</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
    <!--/Registration Form-->
    
    <script src="../../js/validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/jquery.js"></script>
</body>
</html>
