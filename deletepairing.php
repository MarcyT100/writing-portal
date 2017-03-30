<?php
    require_once('connectvars.php');
    
    // Delete linking entry on the book_character_linking_table
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "DELETE FROM book_character_linking_table WHERE character_id = '" . $_GET['character_id'] . "' AND book_id = '" . $_GET['book_id'] . "'";
    mysqli_query($dbc, $query);
    
    // Return user to bookcharacters page
    $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/bookcharacters.php?book_id=' . $_GET['book_id'];
    header('Location: ' . $return_url);
?>