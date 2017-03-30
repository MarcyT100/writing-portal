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
    require_once('Characteradd.php');
    
    // Instantiate object
    $new_add_character = new Characteradd;
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Query database for additional character information
    $query = "SELECT u.username, u.user_id, c.character_id, c.first_name, c.middle_name, c.last_name, c.nick_name, a.alignment, a.family, a.backstory, a.likes, a.dislikes, a.enemies, a.friends, a.personality FROM user_info AS u INNER JOIN character_info AS c using (user_id) INNER JOIN character_add_info AS a USING (character_id) WHERE character_add_id='" . $_GET['character_add_id'] . "'";
    $data = mysqli_query($dbc, $query);
    
    // Continue only if there is only one row of data
    if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        // Set user_id from query
        $user_id = $row['user_id'];
        
        // Display character information
        echo $new_add_character->displayCharacter_add($row);
    }
    
    mysqli_close($dbc);
    
    // If associated user is logged in, give user the option to go to editing page
    if ($_SESSION['user_id'] == $user_id) {
        echo '<p><a href="editaddcharacter.php?character_add_id=' . $_GET['character_add_id'] . '">Edit additional character page</a>';
    }
    
    echo '</section>';
    
?>
</body>
</html>