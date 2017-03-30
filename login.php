<?php
    require_once('connectvars.php');
    
    // Start session
    session_start();
    
    // Display navigation bar
    require_once('navbar.php');
    
    // Clear any leftover error messages
    $error_msg = "";
    
    // If user isn't logged in, try to log them in
    if (!isset($_SESSION['user_id'])) {
        if (isset($_POST['submit'])) {
            // Connect to database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            // Get login data from form
            $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            
            // If both fields are set, query for accound. If found, proceed. If not, display error message.
            if (!empty($user_username) && !empty($user_password)) {
                $query = "SELECT user_id, username FROM user_info WHERE username = '$user_username' AND password = SHA('$user_password')";
                $data = mysqli_query($dbc, $query);
                
                // If query only returns one entry, log user in and set session variables and cookies. Otherwise, display error message.
                if (mysqli_num_rows($data) == 1) {
                    $row = mysqli_fetch_array($data);
                    
                    // Set session variables
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    
                    // Set cookies
                    setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30)); // Set for one month
                    setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30)); // Set for one month
                    
                    // Return user to index.php
                    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                    header('Location: ' . $home_url);
                }
                else {
                    $error_msg = 'Sorry, you must enter a valid username and password.';
                }
            }
            else {
                $error_msg = 'Sorry, you must enter your username and password.';
            }
        }
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Login</title>
     <link rel="stylesheet" type="text/css" href="projectFour.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    
    <h2 class="text-center">Log In</h1>
    
<?php
    // Display error message if session variables are empty
    if (empty($_SESSION['user_id'])) {
        echo '<p>' . $error_msg . '</p>';
    }
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <div class="form-group">
            <label for="username" class="control-label col-sm-2">Username:</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" value="<?php if (!empty($user_username)) echo $user_username; ?>" /<<br />
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label col-sm-2">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" />
            </div>
        </div>
        <span class="centerButton">
            <input type="submit" value="Log In" class="btn btn-primary" name="submit" />
        </span>
    </form>
    
    <br /><p class="text-right">Not a member yet? <a href="signup.php">Join now</a>.</p>
    
</body>
</head>