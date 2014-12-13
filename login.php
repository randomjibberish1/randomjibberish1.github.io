<?php
/* Laura Yoshizawa
 * Assignment 3
 * ITM 352
 */
?>

<?php

// read file user_info.dat and turn file into an array $user_info
    $user_info = convert_user_data();

if (isset($_COOKIE['username'])){
    $cookie_username = $_COOKIE['username'];
}
if (array_key_exists("login_button", $_POST)) {
    // put $_POST['username'] and $_POST['password'] data into an array
    $login_info['username'] = $_POST['username'];
    $login_info['password'] = $_POST['password'];

    // validate login credentials
    // validate if login and password match
    $login_validation = FALSE;
    foreach ($user_info as $key => $user) {
        if ((strtolower($user['username']) === strtolower($login_info['username'])) AND $user['password'] === $login_info['password']) {
            $login_validation = TRUE;
        }
    }  

    $errors['username'] = error_check_username($login_info);
    $errors['password'] = error_check_password($login_info, $login_validation);

    // if there are no errors, then send the user to confirmation.php if the user had a valid cart.
    if ($login_validation == TRUE) {
        setcookie("username", $login_info['username'], time()+600);
    }
}
if (@$cookie_username != ''){
    session_id($cookie_username);
}
session_save_path('.');
session_start();

require 'header.inc';

print '<p>';
// if user is redirected from the registration page, indicate registration was successful and request login
if (array_key_exists('quantity', $_GET)) {
    $quantity = $_GET['quantity'];
    print "<font color=green>Registration successful! </font> <p>";
    $quantity = urlencode($quantity);
}

// if array_key_exists($_POST['login_button'])
if (array_key_exists("login_button", $_POST)) {
    if ($login_validation == TRUE) {
        $_SESSION['username'] = $login_info['username'];
        $_SESSION['logged_in'] = true;
        
        header('Location: saved.php');
    }

    // if there are errors, reprint the login table.
    else {
        print_error_table($errors, $login_info);
    }
} else {
    ?>
    Please enter login information:

    <table>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <tr><td>Username:</td> 
                <td><input type="text" size="20" name="username"></td></tr>
            <tr><td>Password:</td> 
                <td><input type="password" size="20" name="password"></td></tr>
    </table>
    <input type="submit" name="login_button" value="Login">
    </form>

    <p>
        Don't have an account?
    <form action="registration.php" method="POST">
        <input type="submit" name="submit_button" value="Click here to create an account!">       
    </form>  
    <?php
}

// functions
// converting user_info.dat into an array
function convert_user_data() {
    $filename = 'user_info.dat';
    $fp = fopen($filename, 'r');
    while (!feof($fp)) {
        // read a line of product data
        $user_data_line = fgets($fp);
        // get product data parts
        $parts = explode(';', $user_data_line);
        $user_info_array = array('username' => $parts[0],
            'password' => $parts[1],
            'email' => $parts[2]);

        $user_data[] = $user_info_array;
    }
    fclose($fp);
    return $user_data;
}

// error check the username
function error_check_username($login_info) {
    $error['username'] = '';
    if (empty($login_info['username'])) {
        $error['username']['empty'] = "Please enter a username.";
    }
    return $error['username'];
}

// display username errors
function display_username_errors($errors) {
    if (isset($errors['username']['empty']))
        echo " <font color='red'>{$errors['username']['empty']}<br></font>";
}

// error check the password
function error_check_password($login_info, $valid_login) {
    $error['password'] = '';
    if (empty($login_info['password'])) {
        $error['password']['empty'] = "Please enter a password.";
    }
    if ($valid_login == FALSE AND ( !empty($login_info['password']) AND ! empty($login_info['username']))) {
        $error['password']['false'] = "Username or Password is incorrect";
    }
    return $error['password'];
}

// display password errors
function display_password_errors($errors) {
    if (isset($errors['password']['empty']))
        echo " <font color='red'>{$errors['password']['empty']}<br></font>";
    if (isset($errors['password']['false']))
        echo " <font color='red'>{$errors['password']['false']}<br></font>";
}

// print the login form with errors
function print_error_table($errors, $login_info) {
    ?>
    Please enter login information:
    <table>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <tr><td>Username:</td> 
                <td><input type="text" size="20" name="username" value="<?php print $login_info['username'] ?>"></td>
                <td><?php display_username_errors($errors); ?></td></tr>
            <tr><td>Password:</td> 
                <td><input type="password" size="20" name="password"></td>
                <td><?php display_password_errors($errors); ?></td><tr>
                </table>
            <input type="submit" name="login_button" value="Login">
        </form>

        <p>
            Don't have an account?
        <form action="registration.php" method="POST">
            <input type="submit" name="submit_button" value="Click here to create an account!">       
        </form>    
    <?php
}
?>