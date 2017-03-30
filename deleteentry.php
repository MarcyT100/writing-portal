<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Delete Entry</title>
     <link rel="stylesheet" type="text/css" href="projectFour.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
    session_start();
    require_once("navbar.php");
    require_once('Book.php');
    require_once('Series.php');
    require_once('Character.php');
    
    if ($_GET['type'] == "series") {
        // If 'type' is 'series', instantiate object, run delete series method, and return to viewuser.php
        $new_series = new Series;
        $new_series->setSeries_id($_GET['series_id']);
        $new_series->deleteSeries();
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewuser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);
    }
    else if ($_GET['type'] == "book") {
        // If 'type' is 'book', instantiate object, run delete book method, and return to viewuser.php
        $new_book = new Book;
        $new_book->setBook_id($_GET['book_id']);
        $new_book->deleteBook();
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewuser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);    
    }
    else if ($_GET['type'] == "character") {
        // If 'type' is 'character', instantiate object, run delete character method, and return to viewuser.php
        $new_character = new Character;
        $new_character->setCharacter_id($_GET['character_id']);
        $new_character->deleteCharacter();
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewuser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);
    }
    else {
        echo '<p>Error: Something went wrong when creating new entry.</p>';
    }

?>