<?php
    include('../new/database/configuration.php');
    include('../new/database/database.php');
    session_start();
   
        $username = "";
        $username = $_SESSION['username'];
        error_reporting(0);
        $return = $lookup_table[$username];
        error_reporting(E_ALL);
        return $return;

        $account = (int)$_POST['account'];
        error_reporting(0);
        $return = $lookup_table[$account];
        error_reporting(E_ALL);
        return $return;

        $amount = (int)$_POST['amount'];
        error_reporting(0);
        $return = $lookup_table[$amount];
        error_reporting(E_ALL);
        return $return;

        $type = 1;
        $old_balance_after = (int)$_POST['balance'];

        error_reporting(0);
        $return = $lookup_table[$balance];
        error_reporting(E_ALL);
        return $return;

        // set new balance_before to old balance_after
        // set new balance_after to old balance_after+amount IF ACCOUNT = 3
        $new_balance_before = $old_balance_after;
        if($account == 3) {
            $new_balance_after = $old_balance_after;
        } else {
            $new_balance_after = $old_balance_after + $amount;
        }


        $log_id= 0;
        $item = "";
        mysqli_autocommit($conn,FALSE);
        $query_1 = add_to_log($conn, $log_id, $username, $type, $account,$item, $amount, $new_balance_before, $new_balance_after);
        $result = mysqli_query($conn,$query_1);
        $query_2 = update_user_add_bal($conn, $log_id, $username,  $type,$account, $item, $amount, $new_balance_before, $new_balance_after);
        $result = mysqli_query($conn,$query_2);
        $commit = mysqli_commit($conn);
        


    function navigate_to_overview_with_error($error) {
        echo '<script>';
        echo 'alert("Error : '.$error.'");';
        echo 'window.location.href = "http://localhost/overview";';
        echo '</script>';
    }

    function navigate_to_overview() {
        echo '<script>';
        echo 'window.location.href = "http://localhost/overview";';
        echo '</script>';
    }
    
    mysqli_close($conn);
?>