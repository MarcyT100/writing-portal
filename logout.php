<?php
    session_start();
    
    // If user is logged in, log user out
    if(isset($_SESSION['user_id'])) {
        // Clear session variables array
        $_SESSION = array();
        
        // Delete session cookies
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }
        
        // Destroy session
        session_destroy();
    }
    
    // Delete id and username cookies
    setcookie('user_id', '', time() - 3600);
    setcookie('username', '', time() - 3600);
    
    // Return user to index.php
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $home_url);
?>