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
                    <a class="nav-item nav-link active" href="../new/index.php"> Overview <span class="sr-only"></span></a>
                    <a class="nav-item nav-link" href="../new/history.php">History</a>
                    <a class="nav-item nav-link" href=".">Add form</a>
                    <a class="nav-item nav-link" href="../new/account/monthlyExpense.php"> Monthly Expenses </a>
                    <a class="nav-item nav-link text-danger" href="../new/account/logout.php">Log Out</a>
                </div>
            </div>
        </nav>
    </header> 
    <!-- Pre fetching balances-->
    <?php 
                $username = "";
                $cash_balance = 0;
                $credit_balance = 0;
                $debit_balance = 0;
                $query = get_balances($conn,$username);
                $result = mysqli_query($conn,$query);
                if(!$result) {
                    show_alert("Database error!");
                } else {
                    $row = mysqli_fetch_assoc($result);
                    $cash_balance = $row['cash_balance'];
                    $credit_balance = $row['credit_balance'];
                    $debit_balance = $row['debit_balance'];
                }
            ?>

            <!-- Setting balances-->
            <div class="container p-3">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 p-1">
                        <div class="card text-center border-secondary">
                            <div class="card-header text-white bg-success"> Cash Balance </div>
                            <div class="card-body">
                                <?php echo $cash_balance; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 p-1">
                        <div class="card text-center border-secondary">
                            <div class="card-header text-white bg-success"> Debit Balance </div>
                            <div class="card-body">
                                <?php echo $debit_balance; ?>
                            </div>
                        </div>                
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 p-1">
                        <div class="card text-center border-secondary">
                            <div class="card-header text-white bg-danger"> Credit Balance </div>
                            <div class="card-body">
                                <?php echo $credit_balance; ?>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-3">
            <div class="card">
                <div class="card-header"> Total Balance chart </div> 
                <div class="card-body">
                    <div id="div_balance_line_chart"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-6 p-3">
                    <div class="card">
                        <div class="card-header"> Expenditure </div> 
                        <div class="card-body">
                            <div id="div_expenditure_pie_chart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 p-3">
                    <div class="card">
                        <div class="card-header"> Balance Breakdown </div> 
                        <div class="card-body">
                            <div id="div_balance_breakdown"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
    </main>
 
 
 <!--Adding and Removing Money-->
 <div class="modal fade" id="addMoney" tabindex="-1" role="dialog" aria-labelledby="addMoneyCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMoneyLongTitle"> Add to balance </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../account/addExpense.php" method="post" onsubmit="return validateAddAmount()" id="addMoneyForm">
                    <div class="form-group">
                        <label for = "addAmount"> Amount </label>
                        <input type="number" class="form-control form-control-lg" id="addAmount" name="amount" placeholder="Amount in Transaction" required>
                    </div>
                    <div> 
                        <label for = "item"> Item </label>
                        <input type = "text" class = "form-control form-control-lg" id = "item" name = "item" placeholder= "Item added" required>
                    </div>
                    <input type="hidden" value="<?php echo $cash_balance + $debit_balance; ?>" name="balance">
                    <div class="form-group">
                        <label for="addAccount"> Account </label>
                        <select class="custom-select custom-select-lg" name="account" id="addAccount">
                            <option value="1" selected> Cash </option>
                            <option value="2"> Debit </option>
                            <option value="3"> Credit </option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addMoneyForm" class="btn btn-primary px-3"> Add </button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subMoney" tabindex="-1" role="dialog" aria-labelledby="subMoneyCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subMoneyLongTitle"> Subtract from balance </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../account/removeMoney.php" method="post" onsubmit="return validateSubAmount()" id="subMoneyForm">
                    <div class="form-group">
                        <label for="subAmount"> Amount </label>
                        <input type="number" class="form-control form-control-lg" id="subAmount" name="amount" placeholder="Amount in Transaction" required>
                    </div>
                    <div> 
                        <label for = "item"> Item </label>
                        <input type = "text" class = "form-control form-control-lg" id = "item" name = "item" placeholder= "Item added" required>
                    </div>
                    <input type="hidden" value="<?php echo $cash_balance + $debit_balance; ?>" name="balance">
                    <div class="form-group">
                        <label for="account"> Account </label>
                        <select class="custom-select custom-select-lg" name="account" id="subAccount">
                            <option value="1" selected> Cash </option>
                            <option value="2"> Debit </option>
                            <option value="3"> Credit </option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="subMoneyForm" class="btn btn-primary px-3"> Subtract </button>
            </div>
            </div>
        </div>
    </div>

    <!--Footer holding add and subtract buttons-->
    <div class="p-1" style="position:fixed; right:0; bottom:0;">
        <button type="button" class="btn btn-success shadow rounded-circle m-1" style="width:64px; height:64px;" data-toggle="modal" data-target="#addMoney"> +
            <i class="fa fa-plus"></i>
        </button>
        <button type="button" class="btn btn-danger shadow rounded-circle m-1" style="width:64px; height:64px;" data-toggle="modal" data-target="#subMoney"> -
            <i class="fa fa-minus"></i>
        </button>
    </div>


    <!--JS-->
    <script src="../new/js/validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../new/js/jquery.js"></script>
</body>
</html>
    