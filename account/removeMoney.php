<?php
    include('../database/configuration.php');
    include('../database/database.php');
    session_start();
 
        $username = "";
        $username = $_SESSION['username'];
        error_reporting(0);
        $return = $lookup_table[$username];
        error_reporting(E_ALL);
        return $return;

        $account = (int)$_POST['account'];
        $amount = (int)$_POST['amount'];
        $type = 2;
        $old_balance_after = (int)$_POST['balance'];

        // get username from session
        // check if negative balance (validation)
        // set new balance_before to old balance_after
        // set new balance_after to old balance_after + amount IF ACCOUNT = 3
        $new_balance_before = $old_balance_after;
        if($account == 3) {
            $new_balance_after = $old_balance_after;
        } else {
            $new_balance_after = $old_balance_after - $amount;
        }

        if($new_balance_after < 0) {
            navigate_to_overview_with_error("Cannot have negative total balance");
        } else {
            $query = get_user($conn,$username);
            $result = mysqli_query($conn,$query);
            if(!$result) {
                navigate_to_overview_with_error("Database error");
            } else {
                $row = mysqli_fetch_assoc($result);
                switch($account) {
                    case 1:
                        $field = 'cash_balance';
                        $previous = $row['cash_balance'];
                        if($previous-$amount < 0){
                            navigate_to_overview_with_error("Cannot have negative balance");
                            exit;
                        }
                    break;
                    case 2:
                        $field = 'debit_balance';
                        $previous = $row['debit_balance'];
                        if($previous-$amount < 0){
                            navigate_to_overview_with_error("Cannot have negative balance");
                            exit;
                        }
                    break;
                    case 3:
                        $field = 'credit_balance';
                        $previous = $row['credit_balance'];
                        if($previous-$amount < 0){
                            navigate_to_overview_with_error("Cannot have negative balance");
                            exit;
                        }
                    break;
                }

                mysqli_autocommit($conn,FALSE);
                $query_1 = add_to_log($conn, $log_id, $username,$type, $account, $item, $amount, $new_balance_before, $new_balance_after);
                $result = mysqli_query($conn,$query_1);
                $query_2 = update_user_sub_bal($conn,$username,$field,$amount);
                $result = mysqli_query($conn,$query_2);
                $commit = mysqli_commit($conn);
                mysqli_autocommit($conn,TRUE);
                if (!$commit) {
                    navigate_to_overview_with_error("Database error");
                } else {
                    navigate_to_overview();
                }
            }            
        }
    
 
    function navigate_to_login_page($error) {
        echo '<script>';
        echo 'alert("Error : '.$error.'");';
        echo 'window.location.href = "http://localhost/new/login.php";';
        echo '</script>';
    }

    function navigate_to_overview() {
        echo '<script>';
        echo 'window.location.href = "http://localhost/new/overview.php";';
        echo '</script>';
    }   

    function navigate_to_overview_with_error($error) {
        echo '<script>';
        echo 'alert("Error : '.$error.'");';
        echo 'window.location.href = "http://localhost/overview.php";';
        echo '</script>';
    } 

    mysqli_close($conn);
?>