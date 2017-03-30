<?php
    require_once('startsession.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Edit Password</title>
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

    if (!isset($_SESSION['user_id'])) {
        echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
        exit();
    }
    
    // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        // Collect data from form
        $old_password = mysqli_real_escape_string($dbc, trim($_POST['old_password']));
        $new_password = mysqli_real_escape_string($dbc, trim($_POST['new_password']));
        $password_repeat = mysqli_real_escape_string($dbc, trim($_POST['password_repeat']));
        
        // Query the database to get old password
        $query = "SELECT password FROM user_info WHERE user_id = '" . $_SESSION['user_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        // If the old password matches the stored password, the new passwords match, and the new passwords are not empty, update password and display sucsess message. Otherwise, display error message.
        if ((sha1($old_password) == $row['password']) && ($new_password == $password_repeat) && !empty($new_password)) {
            $query = "UPDATE user_info SET password = SHA('$new_password') WHERE user_id = '" . $_SESSION['user_id'] . "'";
            mysqli_query($dbc, $query);
            
            echo "<p>Password sucsessfully updated. <a href='edituser.php?user_id=" . $_SESSION['user_id'] . "'>Click here</a> to return to edit profile.</p>";
        } else {
            echo "<p>Error: Make sure old password is correct and new passwords match.</p>";
        }
    }
    
    mysqli_close($dbc);
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <fieldset>
            <legend class="text-center">Update Password</legend>
            <div class="form-group">
                <label class="control-label col-sm-2" for="old_password">Current Password:</label>
                <div class="col-sm-10">
                    <input type="password" id="old_password" name="old_password" class="form-control" /><br />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="new_password">New Password:</label>
                <div class="col-sm-10">
                    <input type="password" id="new_password" class="form-control" name="new_password" /><br />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="password_repeat">Repeat Password:</label>
                <div class="col-sm-10">
                    <input type="password" id="password_repeat" class="form-control" name="password_repeat" /><br />
                </div>
            </div>
        </fieldset>
        <span class="centerButton">
            <input type="submit" value="Submit" class="btn btn-primary" name="submit" />
        </span>
    </form>
    
</body>
</html>