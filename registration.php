<?php
/* Laura Yoshizawa
 * Assignment 3
 * ITM 352
 */
?>
<?php
session_save_path('.');
session_start();
require 'header.inc';

if (array_key_exists('registration_button', $_POST)) {

    // convert registration information in the _POST into an array
    $registration_info['username'] = $_POST['username'];
    $registration_info['password'] = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $registration_info['email'] = $_POST['email'];

    // convert user_info.dat into an array
    $customer_data = convert_customer_data(); 

    // data validation of registration information
    $errors = array();
    $errors['username'] = validate_username($registration_info, $customer_data);
    $errors['password'] = validate_password($registration_info, $confirm_password);
    $errors['email'] = validate_email($registration_info, $customer_data);
 
    // check to see if any errors exist.
    $error_check = FALSE;
    foreach ($errors as $key => $value) {
        if (!empty($errors[$key])){
            $error_check = TRUE;
        }
    }

    // if there are no errors, then add registration information to user_info.dat and send the user to the invoice page
    if ($error_check == FALSE){
        // writing new registration information to user_info.dat
        //$registration_info_string = '';
        $filename = 'user_info.dat';
        $fp = fopen($filename, "a");
        $registration_info_string = (filesize($filename)> 0) ? "\n" : '';
        $registration_info_string .= implode(';', $registration_info);
        fwrite($fp, $registration_info_string);
        fclose($fp);   
      
        // redirecting user to login.php
        header("Location: login.php");        
    }
    // if there are errors, reprint the registration form, showing errors
    else{
    print_error_table($errors);    
    }
}

// if no registration information was submitted, display base form
else{
?>
<p>
Please fill out all fields:
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <table>
        <tr><td>Username:</td> 
            <td><input type="text" size="20" name="username" value="<?php 
            if (array_key_exists('username', $_POST)){
                echo $_POST['username'];
            }
?>"></td></tr>
        <tr><td>Password:</td> 
            <td><input type="password" size="20" name="password"></td></tr>
        <tr><td>Confirm Password:</td> 
            <td><input type="password" size="20" name="password_confirm"></td></tr>
        <tr><td>E-mail</td>
            <td><input type="email" size="20" name="email" value="<?php 
            if (array_key_exists('email', $_POST)){
                echo $_POST['email'];
            }
?>"></td></tr>            
    </table>  
    <input type="submit" name="registration_button" value="Register!">    
</form>

<?php
}
// functions

// converting user_info.dat into an array
function convert_customer_data(){
    $filename = 'user_info.dat';
    $fp = fopen($filename, 'r');
    while (!feof($fp)) {
        // read a line of product data
        $customer_data_line = fgets($fp);
        // get product data parts
        $parts = explode(';', $customer_data_line);
        $customer_info_array = array('username' => $parts[0],
            'password' => $parts[1],
            'email' => $parts[2]);

        $customer_data[] = $customer_info_array;
    }
    fclose($fp);   
    return $customer_data;
}

// username data validation
// I CHECKED THIS FUNCTION. IT WORKS. NO TOUCHIE.
function validate_username($registration_info, $customer_info_array){
    global $error;
    $error['username'] = array();
    // check if the username exists in user_info.dat
    foreach ($customer_info_array as $key => $value) {
       if (strtolower($value['username']) === strtolower($registration_info['username'])) {
           $error['username']['user_taken'] = "Username unavailable.";
       }
   }
    // check if a username was entered
    if (empty($registration_info['username'])){
        $error['username']['empty'] = "Please enter a username.";
    }
    // check if a username is alphanumeric
    if (!ctype_alnum($registration_info['username']) AND !empty($registration_info['username'])){
        $error['username']['alphanumeric'] = "Username cannot have special characters.";
    }
    // check if a username is at least 4 characters long        
    if (strlen($registration_info['username']) < 4 AND !empty($registration_info['username'])){
        $error['username']['too_short'] = "Username must be at least 4 characters long.";
    }      
    // check if a username is under 11 characters
    if (strlen($registration_info['username']) > 11){
        $error['username']['too_long'] = "Username cannot be longer than 11 characters.";
    }       
    return $error['username'];
}

function display_username_errors($errors) {
    if (isset($errors['username']['user_taken']))
        echo " <font color='red'>{$errors['username']['user_taken']}<br></font>";
    if (isset($errors['username']['empty']))
        echo " <font color='red'>{$errors['username']['empty']}<br></font>";
    if (isset($errors['username']['alphanumeric']))
        echo " <font color='red'>{$errors['username']['alphanumeric']}<br></font>";   
    if (isset($errors['username']['too_short']))
        echo " <font color='red'>{$errors['username']['too_short']}<br></font>"; 
    if (isset($errors['username']['too_long']))
        echo " <font color='red'>{$errors['username']['too_long']}<br></font>";         
}

// password data validation
// THIS WORKSSSSS.  DONT TOUCH.
function validate_password($registration_info, $confirm_password){
    global $error;
    $error['password'] = array();
    // check if password and confirm_password match
    if ($registration_info['password'] != $confirm_password){
        $error['password']['not_match'] = "Passwords do not match.";
        }
    // check if password is at least 6 characters long        
    if (strlen($registration_info['password']) < 6 AND !empty($registration_info['password'])){
        $error['password']['too_short'] = "Password must be at least 6 characters long";
    }      
    // check if a password was entered
    if (empty($registration_info['password'])){
        $error['password']['empty'] = "Please enter a password.";
    }   
    // check if a password uses a semicolon
    if (strpos($registration_info['password'], ';') !== FALSE ){
        $error['password']['semicolon'] = "Password cannot have a semi-colon";
    }
    return $error['password'];
}

function display_password_errors($errors) {
    if (isset($errors['password']['too_short']))
        echo " <font color='red'>{$errors['password']['too_short']}<br></font>";
    if (isset($errors['password']['empty']))
        echo " <font color='red'>{$errors['password']['empty']}<br></font>";
    if (isset($errors['password']['semicolon']))
        echo " <font color='red'>{$errors['password']['semicolon']}<br></font>";
}

function display_password_not_match($errors){
    if (isset($errors['password']['not_match']))
        echo " <font color='red'>{$errors['password']['not_match']}<br></font>";    
}

// email data validation
// THIS WORKS TOO.  NO TOUCH.
function validate_email($registration_info, $customer_info_array){
    global $error;
    $error['email'] = array();
    // check if e-mail exists in user_info.dat        
    foreach ($customer_info_array as $key => $value) {
       if (strtolower($value['email']) === strtolower($registration_info['email'])) {
           $error['email']['email_taken'] = "E-mail already in use.";
       }
   }
    if (empty($registration_info['email'])){
        $error['email']['empty'] = "Please enter an E-mail";
    }
    // email validation to ensure the username, subdomain, and domain name are valid.  Taken from: http://stackoverflow.com/questions/201323/using-a-regular-expression-to-validate-an-email-address
    if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$^", $registration_info['email']) AND !empty($registration_info['email'])){
        $error['email']['invalid'] = "Please enter a valid e-mail address";
    }
   
    return $error['email'];
    
}

function display_email_errors($errors) {
    if (isset($errors['email']['email_taken']))
        echo " <font color='red'>{$errors['email']['email_taken']}<br></font>";
    if (isset($errors['email']['empty']))
        echo " <font color='red'>{$errors['email']['empty']}<br></font>";
    if (isset($errors['email']['invalid']))
        echo " <font color='red'>{$errors['email']['invalid']}<br></font>";
}

function print_error_table($errors){
?>
<p>
Please fill out all fields:
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <table>
        <tr><td>Username:</td> 
            <td><input type="text" size="20" name="username" value="<?php 
            if (array_key_exists('username', $_POST)){
                echo $_POST['username'];
            }
?>"></td>
            <td><?php display_username_errors($errors) ?></td></tr>
        <tr><td>Password:</td> 
            <td><input type="password" size="20" name="password"></td>
            <td><?php display_password_errors($errors)?></td></tr>
        <tr><td>Confirm Password:</td> 
            <td><input type="password" size="20" name="password_confirm"></td>
            <td><?php display_password_not_match($errors)?></td></tr>
        <tr><td>E-mail</td>
            <td><input type="email" size="20" name="email" value="<?php 
            if (array_key_exists('email', $_POST)){
                echo $_POST['email'];
            }
?>"></td>
            <td><?php display_email_errors($errors)?></td></tr>            
    </table>
    <input type="submit" name="registration_button" value="Register!">    
</form>
<?php
}

?>