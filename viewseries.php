<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- View Series</title>
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
    require_once('Series.php'); 
    
    // Instatiate new object
    $new_series = new Series;
    // Set series_id from GET
    $new_series->setSeries_id($_GET['series_id']);
    
    // Get series info
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Query database for series info
    $query = "SELECT s.title, s.description, u.username, u.user_id FROM series_info AS s INNER JOIN user_info AS u USING (user_id) WHERE series_id = '" . $_GET['series_id'] . "'";
    $data = mysqli_query($dbc, $query);
    
    // Continue only if there is only one row of data
    if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        // Set user_id from query
        $user_id = $row['user_id'];
        
        // Display series info
        echo $new_series->displaySeries($row);
    }
    
    mysqli_close($dbc);
    
    // Display series books
    echo $new_series->displayBooks();
    
    // Display series characters
    echo $new_series->displayCharacters();
    
    // If associated user is logged in, allow user to edit or delete series
    if ($_SESSION['user_id'] == $user_id) {
        echo "<section class='userInfo'";
        echo '<p><a href="editseries.php?series_id=' . $_GET['series_id'] . '">Edit series</a>';
        echo ' &#8226; ';
        echo '<a href="deleteentry.php?series_id=' . $_GET['series_id'] . '&amp;type=series">Delete series</a>';
        echo "</section>";
    }
    
?>
</body>
</html>