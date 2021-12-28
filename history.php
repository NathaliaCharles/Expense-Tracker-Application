<?php
session_start();
include('../new/database/configuration.php');
include('../new/database/database.php')
?>

<!DOCTYPE html>
 <html>
 <head>
     <title> History </title>
     <link rel="stylesheet" href="../new/css/main.css">
     <link rel="stylesheet" href="../new/css/bootstrap.min.css">
</head>
<body>

  <!--Header for history-->
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
                     <a class="nav-item nav-link" href="../new/overview.php">Overview</a>
                    <a class="nav-item nav-link active" href=".">History <span class="sr-only"></span></a>
                    <a class="nav-item nav-link" href="../new/addform.php">Add form</a>
                    <a class="nav-item nav-link" href="../new/account/monthlyExpense.php"> Monthly Expenses </a>
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
    <main class="p-3">
        <div class="card container p-1">
            <div class="card-header"> History Log </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr class="table-active">
                                <th scope="col">Type</th>
                                <th scope="col">Account</th>
                                <th scope="col">Item</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Balance Before</th>
                                <th scope="col">Balance After</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($_GET['query'])){
                                    $search_query = $_GET['query'];
                                    $query = get_log_by_query($conn,$username,$search_query);
                                    $result = mysqli_query($conn,$query);
                                    render_from_data($conn,$username,$result);
                                } else {
                                    $username = "";
                                    $query = get_all_logs($conn,$username);
                                    $result = mysqli_query($conn,$query);
                                    render_from_data($conn,$username,$result);
                                }

                                function render_from_data($conn,$username,$result) {
                                    if(mysqli_num_rows($result)==0) {
                                        echo '<tr><td colspan="8" class="text-center"> No history available. </td></tr>';
                                    } else {
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            $log_id = $row['log_id'];
                                            $type = $row['type'];
                                            $account = $row['account'];
                                            $item = $row['item'];
                                            $amount = $row['amount'];
                                            $mysqlDate = $row['log_date'];
                                            $phpdate = strtotime( $mysqlDate );
                                            $date = date('d/m/y g:i A', $phpdate );
                                            $balance_before = $row['balance_before'];
                                            $balance_after = $row['balance_after'];

                                            echo '<tr>';
                                            echo '<td>';
                                            if($type == 1) {
                                                echo '<i class="fa fa-plus text-success"></i>';
                                            } else if($type == 2){
                                                echo '<i class="fa fa-minus text-danger"></i>';
                                            } else {
                                                echo '<i class="fa fa-exchange-alt text-warning"></i>';
                                            }
                                            echo '</td>';
                                            echo '<td>';
                                            switch($account) {
                                                case 1 :
                                                    echo 'Cash';
                                                break;
                                                case 2 :
                                                    echo 'Debit';
                                                break;
                                                case 3 :
                                                    echo 'Credit';
                                                break;
                                            }
                                            echo '</td>';
                                            echo '<td>';
                                            echo $amount;
                                            echo '</td>';
                                            echo '<td>';
                                            echo $date;
                                            echo '</td>';
                                            echo '<td>';

                                            //Undo transaction button form
                                            echo '<form action="../new/account/log.php" onsubmit="return undoTransactionConfirm()" method="post">';
                                            echo '<button type="submit" class="btn"><i class="fa fa-undo text-dark"></i></button>';
                                            echo '<input type="hidden" value="'.$mysqlDate.'" name="logDate" id="logDate">';
                                            echo '</form>';
                                            echo '</td>';                                    
                                            echo '</tr>';
                                        }
                                    }
                                }

                                function show_alert($error) {
                                    echo '<script>';
                                    echo 'alert("Error : '.$error.'");';
                                    echo '</script>';
                                }

                                mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
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