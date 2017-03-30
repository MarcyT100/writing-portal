<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Book Console Panel</title>
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
    
    // Query to determine every character associated with the current user_id
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SELECT first_name, last_name, character_id FROM character_info WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY last_name, first_name";
    $data = mysqli_query($dbc, $query);
    
    echo "<table class='table'>";
    
    // For every character associated with the current user_id, query to determine whether they are in the linking table associated with the current book
    while ($row = mysqli_fetch_array($data)) {
        
        $book_query = "SELECT character_id, book_id FROM book_character_linking_table WHERE character_id = '" . $row['character_id'] . "' AND book_id = '" . $_GET['book_id'] . "'";
        $book_data = mysqli_query($dbc, $book_query);

        echo "<tr>";
        
        // If the character is not in the current book, allow user to add character
        if (mysqli_num_rows($book_data) == 0) {
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td><td><a href='addpairing.php?character_id=" . $row['character_id'] . "&amp;book_id=" . $_GET['book_id'] . "'><span class='glyphicon glyphicon-plus'></span></a></td>";
        } 
        // If the character is in the current book, allow user to remove character
        else if (mysqli_num_rows($book_data) == 1) {
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td><td><a href='deletepairing.php?character_id=" . $row['character_id'] . "&amp;book_id=" . $_GET['book_id'] . "'><span class='glyphicon glyphicon-minus'></span></a></td>";
        }
        else {
            // Do nothing because this is an error
        }
        
        echo "</tr>";
    }

    echo "</table>";
    
    echo "<p><a href='viewbook.php?book_id=" . $_GET['book_id'] . "'>Return to book</a></p>";
    
?>
</body>
</html>