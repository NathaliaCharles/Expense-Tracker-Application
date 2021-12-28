<?php

    // Auth queries
    function check_username($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        return "SELECT * FROM tbluser WHERE username='$mysql_username'";
    }
    function insert_username($conn,$username,$pass) {
        $stripped_username = stripcslashes($username);
        $stripped_pass = stripcslashes($pass);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        $mysql_pass = mysqli_real_escape_string($conn,$stripped_pass);
        $hashed_pass = password_hash($mysql_pass,PASSWORD_DEFAULT);
        return "INSERT INTO `tbluser`(`username`, `hash_pwd`) VALUES ('$mysql_username','$hashed_pass')";
    }


    // User table queries
    function get_user($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        return "SELECT * FROM tbluser WHERE username = '$mysql_username'";
    }
    function get_balances($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        return "SELECT credit_balance ,debit_balance, cash_balance FROM tbluser WHERE username = '$mysql_username'";
    }


    // Log table queries
    function get_balance_graph_data($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        return "SELECT balance_after,log_date FROM expense WHERE username = '$mysql_username' ORDER BY log_date ASC;";
    }
    function get_total_balance($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        return "SELECT balance_after FROM expense WHERE username = '$mysql_username' ORDER BY log_id DESC limit 1;";
    }

    function get_spending_analysis_graph_data($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        // Sql without credit : select count(case type when 1 then 1 else null end) as count_add,count(case type when 2 then 1 else null end) as count_sub  from log WHERE username='test' AND account != 3
        // Includes credit balance add as count_sub and credit subtract as count_add.
        return "SELECT count(case when ((type = 1 AND account != 3) OR (type = 2 and account = 3)) then 1 else null end) as count_add,count(case when ((type = 2 and account != 3) or (type = 1 and account = 3)) then 1 else null end) as count_sub  FROM expense WHERE username = '$mysql_username'";
    }
    function get_all_logs($conn,$username) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        return "SELECT log_id, type, account, item,amount,log_date,balance_after,balance_before FROM expense WHERE username='$mysql_username' ORDER BY log_date DESC";
    }
    function get_log_by_query($conn,$username,$query) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        $stripped_query = stripcslashes($query);
        $mysql_query = mysqli_real_escape_string($conn,$stripped_query);
        if(trim($mysql_query) === ''){
            return get_all_logs($conn,$username);
        } else {
            return "SELECT * FROM expense WHERE username='$mysql_username'  against('$mysql_query' IN natural language mode) ORDER BY log_date DESC";
        }
    }
    
    function get_logs_from($conn,$logDate) {
        $stripped_logDate = stripcslashes($logDate);
        $mysql_logDate = mysqli_real_escape_string($conn,$stripped_logDate);
        return "SELECT * FROM expense WHERE log_date >= '$mysql_logDate'";
    }
    function perform_undo_in_balance($conn,$type,$account,$amount,$username){
        $stripped_type = stripcslashes($type);
        $mysql_type = mysqli_real_escape_string($conn,$stripped_type);
        $stripped_account = stripcslashes($account);
        $mysql_account = mysqli_real_escape_string($conn,$stripped_account);
        $stripped_amount = stripcslashes($amount);
        $mysql_amount = mysqli_real_escape_string($conn,$stripped_amount);
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        switch($mysql_account) {
            case 1 :
                // transaction on cash balance only (add/sub)
                if($mysql_type == 1) {
                    // added to cash, so subtract amount
                    return "UPDATE tbluser SET cash_balance = cash_balance - '$mysql_amount' WHERE username = '$mysql_username'";
                } else if($mysql_type == 2){
                    // subtracted from cash, so add amount
                    return "UPDATE tbluser SET cash_balance = cash_balance + '$mysql_amount' WHERE username = '$mysql_username'";
                }
            break;
            case 2 :
                // transaction on debit balance only (add/sub)
                if($mysql_type == 1) {
                    // added to debit, so subtract amount
                    return "UPDATE tbluser SET debit_balance = debit_balance - '$mysql_amount' WHERE username = '$mysql_username'";
                } else if($mysql_type == 2){
                    // subtracted from debit, so add amount
                    return "UPDATE tbluser SET debit_balance = debit_balance + '$mysql_amount' WHERE username = '$mysql_username'";
                }
            break;
            case 3 :
                // transaction on credit balance only (add/sub)
                if($mysql_type == 1) {
                    // added to credit, so subtract amount
                    return "UPDATE tbluser SET credit_balance = credit_balance - '$mysql_amount' WHERE username = '$mysql_username'";
                } else if($mysql_type == 2){
                    // subtracted from credit, so add amount
                    return "UPDATE tbluser SET credit_balance = credit_balance + '$mysql_amount' WHERE username = '$mysql_username'";
                }
            break;
            
        }
        
    }
    function remove_log_with_id($conn,$log_id){
        $stripped_logId = stripcslashes($log_id);
        $mysql_logId = mysqli_real_escape_string($conn,$stripped_logId);
        return "DELETE FROM expense WHERE log_id='$mysql_logId'";
    }

    //Relative statements
    function add_to_log($conn, $log_id,$username,int $type,int $account, $item,int $amount,int $new_balance_before,int $new_balance_after) {
        $stripped_username = stripcslashes($username);
        $mysql_logId = mysqli_real_escape_string($conn,$log_id);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        $mysql_type = mysqli_real_escape_string($conn,$type);
        $mysql_account = mysqli_real_escape_string($conn,$account);
        $mysql_item = mysqli_real_escape_string($conn,$item);
        $mysql_amount = mysqli_real_escape_string($conn,$amount);
        $mysql_balance_before = mysqli_real_escape_string($conn,$new_balance_before);
        $mysql_balance_after = mysqli_real_escape_string($conn,$new_balance_after);
        switch($mysql_account) {
           case 1 :
               $field = "cash_balance";
           break;
           case 2 :
               $field = "debit_balance";
           break;
           case 3 :
               $field = "credit_balance";
           break;
        }
        $field = 0;
        $sql = "INSERT INTO expense (username,type,account,item,amount,balance_before,balance_after) VALUES ('$mysql_username',$mysql_type,$mysql_account,$mysql_item,$mysql_amount,$mysql_balance_before,$mysql_balance_after)";
        $sql2 = "UPDATE tbluser SET $field = $field + $mysql_amount WHERE username = $mysql_username";
        return $sql;
    }
    function update_user_add_bal($conn,$log_id, $username,int $type,int $account, $item,int $amount,int $new_balance_before,int $new_balance_after) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        $mysql_type = mysqli_real_escape_string($conn,$type);
        $mysql_account = mysqli_real_escape_string($conn,$account);
        $mysql_item = mysqli_real_escape_string($conn,$item);
        $mysql_amount = mysqli_real_escape_string($conn,$amount);
        $mysql_balance_before = mysqli_real_escape_string($conn,$new_balance_before);
        $mysql_balance_after = mysqli_real_escape_string($conn,$new_balance_after);

        switch($mysql_account) {
            case 1 :
                $field = "cash_balance";
            break;
            case 2 :
                $field = "debit_balance";
            break;
            case 3 :
                $field = "credit_balance";
            break;
        }
        $field = 0;
        $sql = "INSERT INTO expense (username,type,account,item,amount,balance_before,balance_after) VALUES ('$mysql_username',$mysql_type,$mysql_account,$mysql_item,$mysql_amount,$mysql_balance_before,$mysql_balance_after)";
        $sql2 = "UPDATE tbluser set $field = $field + $mysql_amount where username = '$mysql_username'";
        return $sql2;
    }
    function update_user_sub_bal($conn,$username,$field,int $amount) {
        $stripped_username = stripcslashes($username);
        $mysql_username = mysqli_real_escape_string($conn,$stripped_username);
        $mysql_field = mysqli_real_escape_string($conn,$field);
        $mysql_amount = mysqli_real_escape_string($conn,$amount);

        $sql = "INSERT INTO expense (username,field,amount) VALUES ('$mysql_username',$mysql_field,$mysql_amount)";
        $sql2 = "UPDATE tbluser set $mysql_field = $mysql_field - $mysql_amount where username = '$mysql_username'";
        return $sql2;
    }
?>