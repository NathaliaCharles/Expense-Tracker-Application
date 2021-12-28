<?php
session_start();
require('../new/database/configuration.php');
if(isset($_SESSION['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
  }
    $username = "";
    $query = mysqli_query($conn,"SELECT id FROM login WHERE   username = '$username' && password = '$password' " );
    if ($query) {
        //$message = "you have successfully login";
    } else {
        //$message = "invalid details";
    }
    ?>


<!DOCTYPE html>
<html>
<head>
    <title>Login to Expense Tracker</title>
    <link rel="stylesheet" href="../new/css/bootstrap.min.css">
    <link rel="stylesheet" href="../new/css/site.css">
</head>
<body> 
    
<!--Login Form-->
<main>
    <div class = "w3-container"> 
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			    <div class="login-panel panel panel-default">
                    <h1 class= "mb-3 mt-3"> Log in </h1>
                    <form action="" method="POST" onsubmit="return validateLoginForm()">
                        <div class="form-group">
                            <?php
                            //if ($message){
                            //echo $message;
                            //}
                            ?>
                       
                          <label for="username"> Username: </label>
                          <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                          <label for="password"> Password: </label>
                          <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg"> Submit </button>
                    </form>
                    <p class="pt-3">
                        Don't have an account? Create it
                        <a href="./register.php"> here. </a>
                    </p>
                </div>
            </div>
        </div>
    </main>
    <!--/Login Form-->


    <script src="../../js/validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../new/js/jquery.js"></script>
    
</body>
</html>