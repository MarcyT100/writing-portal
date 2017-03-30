<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Sign Up</title>
     <link rel="stylesheet" type="text/css" href="projectFour.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    
<?php
    session_start();
    require_once('connectvars.php');
    require_once('navbar.php');
    
    // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Get data from the form if it was submitted
    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
        
        // If all fields have been filled in, continue
        if (!empty($username) && !empty($password1) && !empty($password2)) {
            
            // If the passwords match, continue.
            if ($password1 == $password2) {
                
                // Query database to see if any other accounts have the same username.
                $query = "SELECT * FROM user_info WHERE username = '$username'";
                $data = mysqli_query($dbc, $query);
                
                // If username does not exist, add account to database
                if (mysqli_num_rows($data) == 0) {
                    $query = "INSERT INTO user_info (username, password) VALUES ('$username', SHA('$password1'))";
                    mysqli_query($dbc, $query);
                    
                    // Display confirmation message to the user
                    echo '<p>Welcome, ' . $username . ', to the Writing Portal! You are all ready to <a href="login.php">log in</a> and start exploring.';
                    
                    mysqli_close($dbc);
                    exit();
                }
                else {
                    // If this username is already in use, display error message
                    echo '<p>Error: Another account already exists for ' . $username . '. Please select another username.</p>';
                    $username = "";
                }
            }
            else {
                // If the passwords do not match, display error message.
                echo '<p>Error: Passwords do not match.</p>';
            }
        }
        else {
            // If user does not all information or passwords do not match, display error message.
            echo '<p>Error: Please fill in all information.</p>';
        }
    }
    
    mysqli_close($dbc);
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <fieldset>
            <legend class="text-center">Sign Up Information</legend>
            <div class="form-group">
                <label class="control-label col-sm-2" for="username">Username:</label>
                <div class="col-sm-10">
                    <input type="text" id="username" name="username" class="form-control" value="<?php if (!empty($username)) echo $username; ?>" /><br />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="password1">Password:</label>
                <div class="col-sm-10">
                    <input type="password" id="password1" class="form-control" name="password1" /><br />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="password2">Repeat Password:</label>
                <div class="col-sm-10">
                    <input type="password" id="password2" class="form-control" name="password2" /><br />
                </div>
            </div>
        </fieldset>
        <span class="centerButton">
            <input type="submit" value="Sign Up" class="btn btn-primary" name="submit" />
        </span>
    </form>
</body>
</html>