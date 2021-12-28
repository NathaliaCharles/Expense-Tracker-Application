function validateLoginForm() {
    //check username, password and length of variables
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    if (isEmptyOrBlank(username)) {
        alert("Username must be filled out!");
        return false;
    } else if(isEmptyOrBlank(password)) {
        alert("Password must be filled out!");
        return false;
    } else if(password.length < 8) {
        alert("Password is too short!");
        return false;
    } else if(username.length > 20){
        alert("Username is too long!");
        return false;
    } else {
        return true;
    }
}

function validateRegisterForm() {
    //check username, passwords and lenth of variables
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var repassword = document.getElementById("repassword").value;
    if(password != repassword){
        alert("Both passwords do not match. Please enter matching passwords!")
        return false;
    } else if (isEmptyOrBlank(username)) {
        alert("Username must be filled out!");
        return false;
    } else if(isEmptyOrBlank(password)) {
        alert("Password must be filled out!");
        return false;
    }  else if(isEmptyOrBlank(repassword)) {
        alert("Password must be filled out!");
        return false;
    }  else if (password.length < 8) {
        alert("Password is too short!");
        return false;
    } else if(username.length > 20){
        alert("Username is too long!");
        return false;
    } else {
        return true;
    }
}


function validateAddAmount() {
    var amount = document.getElementById("addAmount").value;
    var desc = document.getElementById('addDesc').value;
    if(isEmptyOrBlank(amount)) {
        alert("Amount must be filled out!");
        return false;
    } else if (amount <= 0) {
        alert("Invalid amount!\nUse Subtract for removing.");
        return false;
    } else if(isEmptyOrBlank(desc)) {
        alert("Invalid description");
        return false;
    } else {
        return true;
    }
}

function validateSubAmount() {
    var amount = document.getElementById("subAmount").value;
    var desc = document.getElementById('subDesc').value;
    if(isEmptyOrBlank(amount)) {
        alert("Amount must be filled out!");
        return false;
    } else if (amount <= 0) {
        alert("Invalid amount!");
        return false;
    } else if(isEmptyOrBlank(desc)) {
        alert("Invalid description");
        return false;
    } else {
        return true;
    }
}



function undoTransactionConfirm() {
    //undo transaction form
    var confirmation = confirm("Are you sure to undo this transaction?\nThis will remove all transactions done after the selected transaction aswell.");
    return confirmation;
}

function isEmptyOrBlank(string) {
    //validate empty string
    if(string == "" || string === "" || !string || /^\s*$/.test(string)) {
        return true;
    } else{
        return false;
    }
}