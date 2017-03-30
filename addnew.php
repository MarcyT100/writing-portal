<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Add New Entry</title>
     <link rel="stylesheet" type="text/css" href="projectFour.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
    session_start();
    require_once("connectvars.php");
    require_once('Series.php');
    require_once('Book.php');
    require_once('Character.php');
    require_once('Characteradd.php');
    
    // If type is series, add new series and return to edituser.php
    if ($_GET['type'] == "series") {
        $new_series = new Series;
        $new_series->addSeries();
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/edituser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);
    }
    // If type is book, add new book and return to edituser.php
    else if ($_GET['type'] == "book") {
        $new_book = new Book;
        $new_book->addBook();
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/edituser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);
    }
    // If type is character, add new character and return to edituser.php
    else if ($_GET['type'] == "character") {
        $new_character = new Character;
        $new_character->addCharacter();
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/edituser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);
    }
    // if type is character_add, add new additional information page and return to viewcharacter.php
    else if ($_GET['type'] == "character_add") {
        $new_add_character = new Characteradd;
        $character_id = $_GET['character_id'];
        $new_add_character->addCharacter_add($character_id);
        
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewcharacter.php?character_id=' . $_GET['character_id'];
        header('Location: ' . $return_url);
    }
    else {
        echo '<p>Error: Something went wrong when creating new entry.</p>';
    }

?>