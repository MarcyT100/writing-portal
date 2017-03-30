<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- View Character</title>
     <link rel="stylesheet" type="text/css" href="projectFour.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    
<?php
    session_start();
    require_once('navbar.php');
    require_once('connectvars.php');
    require_once('Character.php');
    
    // Instatiate new object
    $new_character = new Character;
    // Set character_id from GET
    $new_character->setCharacter_id($_GET['character_id']);
    
    // Get character info
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Query database for character information
    $query = "SELECT character_id, first_name, last_name, middle_name, nick_name, alias, c.gender, age, motivation, occupation, eye_color, hair_color, height, other_appearance, username, u.user_id, character_id FROM user_info AS u INNER JOIN character_info AS c USING (user_id) WHERE character_id = '" . $_GET['character_id'] . "' ORDER BY last_name, first_name";
    $data = mysqli_query($dbc, $query);
     
    // Continue only if there is only one row of data
    if (mysqli_num_rows($data) == 1) {
        // Display character info
        $row = mysqli_fetch_array($data);
        // Set user id from query
        $user_id = $row['user_id'];
        
        // Display character information
        echo $new_character->displayCharacter($row);
    }
    
    echo "<section class='userInfo'>";
    
    // Run a query to determine if an additional character page exists
    $query = "SELECT character_add_id FROM character_add_info WHERE character_id ='" . $_GET['character_id'] . "'";
    $result = mysqli_query($dbc, $query);
    
    // If there is one result, display link to additional character page. If there is not any results and the associated user is logged in, allow user the option to add additional character page.
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        echo "<p><a href='viewaddcharacter.php?character_add_id=" . $row['character_add_id'] . "'>See Additional Character Information</a></p>";
    }
    else if (mysqli_num_rows($result) == 0 && $_SESSION['user_id'] == $user_id) {
        echo "<p><a href='addnew.php?character_id=" . $_GET['character_id'] . "&amp;type=character_add'>Add additional character information</a></p>";
    }
    else {
        // Do nothing if there is more than one entries. This is an error.
    }
    
    mysqli_close($dbc);
    
    // If associated user is logged in, allow user to edit or delete character
    if ($_SESSION['user_id'] == $user_id) {
        echo '<p><a href="editcharacter.php?character_id=' . $_GET['character_id'] . '">Edit character</a>';
        echo ' &#8226; ';
        echo '<a href="deleteentry.php?character_id=' . $_GET['character_id'] . '&amp;type=character">Delete character</a></p>';
    }
    
    echo '</section>';
    
?>