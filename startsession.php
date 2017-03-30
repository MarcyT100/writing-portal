<?php
    session_start();
    
    // Set session variables if they are not already set
    if (!isset($_SESSION['user_id'])) {
        // If cookies are set, set session variables based on them
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }
?>