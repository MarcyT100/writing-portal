<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- View Profile</title>
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
    require_once('User.php');
    
    // Instantiate new object
    $new_user = new User;

    // Get user info
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Query database for user information
    $query = "SELECT username, bio, gender FROM user_info WHERE user_id = '" . $_GET['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    
    // Only continue if there is only one data row
    if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        
        // Display user info
        echo $new_user->displayUser($row);
    }
    else {
        echo '<p>Error: Issue accessing user.</p>';
    }
    
    mysqli_close($dbc);
    
    // Display user's series
    echo $new_user->displayAllSeries();
    
    // Display user's books
    echo $new_user->displayAllBooks();
    
    // Display user's characters
    echo $new_user->displayAllCharacters();
    
    // If user is logged in, allow user to edit profile
    if ($_SESSION['user_id'] == $_GET['user_id']) {
        echo '<section class="userInfo">';
        echo '<p><a href="edituser.php">Click here</a> to edit your profile.</p>';
        echo '</section>';
    }

?>

</body>
</html>