<?php
    require_once('startsession.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Edit Profile</title>
     <link rel="stylesheet" type="text/css" href="projectFour.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
    
<?php
    require_once('connectvars.php');
    require_once('navbar.php');
    require_once('User.php');
    
    if (!isset($_SESSION['user_id'])) {
        echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
        exit();
    }
    
    // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        // Get profile data from form
        $bio = mysqli_real_escape_string($dbc, trim($_POST['bio']));
        $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
        
        $new_user = new User;
        $new_user->setBio($bio);
        $new_user->setGender($gender);
        $new_user->setOld_picture($old_picture);
        $new_user->setNew_picture($new_picture);
            
        // Update user info on the database
        $new_user->updateUser();
            
        mysqli_close($dbc);
            
        // Return user to viewuser.php
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewuser.php?user_id=' . $_SESSION['user_id'];
        header('Location: ' . $return_url);
    }
    else {
        // Get profile information from database
        $query = "SELECT username, bio, gender FROM user_info WHERE user_id = '" . $_SESSION['user_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        // If query suceeds, set variables. Otherwise, display error message.
        if ($row != NULL) {
            $username = $row['username'];
            $bio = $row['bio'];
            $gender = $row['gender'];
        }
        else {
            echo '<p>Error: There was a problem accessing your account.</p>';
        }
    }
    
?>
    <section class="halfDescription">
        <h3 class="text-center"><?php echo $username; ?></h3>
        <h5 class="text-center"><a href="editpassword.php">Click here</a> to update password.</h5>
        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
            <div class="form-group">
                <label for="bio" class="control-label col-sm-2">BIO:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="bio"><?php if (!empty($bio)) echo $bio; ?></textarea><br />
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="control-label col-sm-2">Gender:</label>
                <div class="col-sm-10">
                    <select name="gender" class="form-control">
                        <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
                        <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
                    </select><br />
                </div>
            </div>
        <span class="centerButton">
            <input type="submit" value="Save Profile" class="btn btn-primary" name="submit" />
        </span>
    </form>
    </section>
    
<?php
    // Instantiate new object
    $new_user = new User;
    
    echo "<section class='halfDescription'>";
    
    // Query database to find all series associated with current user_id
    $query = "SELECT series_id, title FROM series_info WHERE user_id ='" . $_SESSION['user_id'] . "' ORDER BY series_id DESC";
    $data = mysqli_query($dbc, $query);
    
    // Display all series created by current user
    echo "<h4>Series</h4>";
    echo "<table>";
    
    // Display each series
    while ($row = mysqli_fetch_array($data)) {
        echo $new_user->displaySeries($row);
    }
    
    echo "<tr><td>";
    
    // Display add new series link
    $type = "series";
    echo $new_user->displayAddLink($type);
    
    echo "</td></tr>";
    echo "</table>";
    
    // Query database to find all books associated with current user_id
    $query = "SELECT book_id, title FROM book_info WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY book_id DESC";
    $data = mysqli_query($dbc, $query);
    
    // Display all books created by current user
    echo "<h4>Books</h4>";
    echo "<table>";
    
    // Display each book
    while ($row = mysqli_fetch_array($data)) {
        echo $new_user->displayBook($row);
    }

    echo "<tr><td>";
    
    // Display add new book link
    $type = "book";
    echo $new_user->displayAddLink($type);
    
    echo "</td></tr>";
    echo "</table>";
    
    // Query dataase to find all characters associated with current user_id
    $query = "SELECT character_id, first_name, last_name FROM character_info WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY character_id DESC";
    $data = mysqli_query($dbc, $query);
    
    // Display all characters created by current user
    echo "<h4>Characters</h4>";
    echo "<table>";
    
    // Display each character
    while ($row = mysqli_fetch_array($data)) {
        $display_string = $new_user->displayCharacter($row);
        echo $display_string;
    }
    
    echo "<tr><td>";
    
    // Display add new character link
    $type = "character";
    echo $new_user->displayAddLink($type);
    
    echo "</td></tr>";
    echo "</table>";
    echo "</section>";
    
    mysqli_close($dbc);
    
    
?>
    
</body>
</html>
