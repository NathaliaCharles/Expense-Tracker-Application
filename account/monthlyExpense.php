<?php
    include('../database/database.php');
    include('../database/configuration.php')
    
?>


<!DOCTYPE html>
<html>
<head>
	<title> Monthly Expense Report</title>
	<link rel = "stylesheet"  href = "../css/site.css">
	<link rel = "stylesheet" href = "../css/bootstrap.min.css">
</head>
<body>
    <!--Header for monthly expenses-->
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
                     <a class="nav-item nav-link" href="../new/index.php">Overview</a>
                     <a class="nav-item nav-link active" href="../new/history.php">History <span class="sr-only"></span></a>
                     <a class="nav-item nav-link" href="../new/addform.php">Add form</a>
                     <a class="nav-item nav-link active" href="."> Monthly Expenses <span class="sr-only"></span></a>
                     <a class="nav-item nav-link text-danger" href="../new/account/logout.php">Log Out</a>
                </div>
                <form class="form-inline" action="" method="GET">
                    <input class="form-control mr-sm-2" type="text" name="query" placeholder="Enter Query here" aria-label="Search">
                    <input class="btn btn-outline-primary my-2 my-sm-0" type="submit" value="Search">
                </form>
            </div>
        </nav>
    </header>
			
<!--Main Page-->
    <main>
        <div class="center-page container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h1 class="mb-3 mt-3"> Monthly Expense Report</h1>
                    <form action="../account/addExpense.php" method="POST">
                        <div class="form-group">
                        <hr class = "mb-3">
                          <label for="fdate"> From Date: </label>
                          <input type="date" class="form-control form-control-lg" id="fromdate" name="fromdate"  required="true">
                        </div>
                        <div class="form-group">
                          <label for="tdate"> To Date: </label>
                          <input type="date" class="form-control form-control-lg" id="todate" name="todate" required="true">
                        </div>
                        <hr class = "mb-3">
                        <div class="form-group has-success">
                        <button type="submit" class="btn btn-primary btn-lg"> Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <script src="../../js/validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/jquery.js"></script>
</body>
</html>