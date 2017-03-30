<?php

    // Generate navigation bar
    echo '<hr />';
    
    // If user is logged in, display home, view profile, and logout. Otherwise, display home, login, and sign up.
    if (isset($_SESSION['username'])) {
        echo '<span class="small">';
        echo '<a href="index.php">Home</a> &#8226; ';
        echo '<a href="viewuser.php?user_id=' . $_SESSION['user_id'] . '">View Profile</a> &#8226; ';
        echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a>';
        echo '</span>';
    }
    else {
        echo '<span class="small">';
        echo '<a href="index.php">Home</a> &#8226; ';
        echo '<a href="login.php">Log In</a> &#8226; ';
        echo '<a href="signup.php">Sign Up</a>';
        echo '</span>';
    }
    
    echo '<hr />';

?>