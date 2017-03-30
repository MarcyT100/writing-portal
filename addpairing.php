<?php
    // The purpose of this file is to add a pairing to the book_character_linking_table associating a book and a character
    require_once('connectvars.php');
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "INSERT INTO book_character_linking_table (character_id, book_id) VALUES (" . $_GET['character_id'] . ", " . $_GET['book_id'] . ")";
    mysqli_query($dbc, $query);
    
    $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/bookcharacters.php?book_id=' . $_GET['book_id'];
    header('Location: ' . $return_url);
?>