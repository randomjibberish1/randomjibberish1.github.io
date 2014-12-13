<?php
/*
  Laura Yoshizawa
  Assignment 3
  ITM 352
 * 
 */

if (isset($_COOKIE['username'])){
    $cookie_username = $_COOKIE['username'];
    if (@$cookie_username != ''){
    session_id($cookie_username);
    }
}
session_save_path('.');
session_start();
$_SESSION['logged_in'] = false;

header('Location:index.php?logout=true');
?>