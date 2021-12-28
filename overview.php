<?php
session_start();
include('../new/database/configuration.php');
include('../new/database/database.php');


?>
<!DOCTYPE html>
<html>
    <head>
        <title> Overview </title>
        <link rel = "stylesheet" href = "../new/css/site.css">
        <link rel = "stylesheet" href = "../new/css/bootstrap.min.css">

    </head>
    <body>
       

    <!-- Header for overview-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="http://localhost">
                <img src="../new/logo-tracker/logotracker-36.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav mr-auto">
                    <a class="nav-item nav-link active" href="."> Overview <span class="sr-only"></span></a>
                    <a class="nav-item nav-link" href="../new/history.php">History</a>
                    <a class="nav-item nav-link" href="../new/addform.php">Add form</a>
                    <a class="nav-item nav-link" href="../new/account/monthlyExpense.php"> Monthly Expenses </a>
                    <a class="nav-item nav-link text-danger" href="../new/account/logout.php">Log Out</a>
                </div>
            </div>
        </nav>
    </header>
    
    <!--Main page-->
    <main>
        <div class="alert alert-secondary">
            <div class="text-center p-3 h3">
                Total Balance : 
                <?php
                        $username = "";
                        $query = get_total_balance($conn, $username);
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) == 0) {
                            echo "0";
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            echo $row['balance_after'];
                        }
                
                        error_reporting(0);
                        $return = $lookup_table[$username];
                        error_reporting(E_ALL);
                        return $return;

                        //Monthly Expense
                        $username = $_SESSION['username'];
                        $monthdate=  date("Y-m-d", strtotime("-1 month")); 
                        $crrntdte=date("Y-m-d");
                        $query3=mysqli_query($conn,"SELECT sum(balance_after)  as monthlyexpense FROM expense WHERE (log_date) BETWEEN '$monthdate' AND '$crrntdte') && (username ='$username')");
                        $result3=mysqli_query($conn, $query3);
                        $sum_monthly_expense=$result2['monthlyexpense'];
                ?>
				<div class="panel-body">
						<h4>Last 30day's Expenses</h4>
				<div class="chart" id="chart" data-percent=" <?php echo $sum_monthly_expense;?>" >
                <span class="percent">
                <?php 
                        if($sum_monthly_expense=="") {
                            echo "0";
                        } else {
                            echo $sum_monthly_expense;
                        }

	            ?>
                </span>
            </div>
		</div>
	</div>
</div>
    

    <!--JS-->
    <script src="../new/js/validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../new/js/jquery.js"></script>
</body>
</html>