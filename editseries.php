<?php
    require_once('startsession.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Edit Series</title>
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
    require_once('navbar.php');
    require_once('Series.php');
    
    if (!isset($_SESSION['user_id'])) {
        echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
        exit();
    }
    
    // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        // Get series info from form
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
        $series_id = mysqli_real_escape_string($dbc, trim($_POST['series_id']));
        
        // Instantiate a new object
        $new_series = new Series;
        
        // Set object variables
        $new_series->setTitle($title);
        $new_series->setDescription($description);
        $new_series->setSeries_id($series_id);
        
        // Add information to the database
        $new_series->updateSeries();
        
        mysqli_close($dbc);
        
        // Return user to viewseries.php
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewseries.php?series_id=' . $series_id;
        header('Location: ' . $return_url);
    }
    else {
        // Get series info
        $query = "SELECT title, description, user_id FROM series_info WHERE series_id = '" . $_GET['series_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        // If the query suceeds and the user_ids match, set variables from query. Otherwise, display error message.
        if ($row != NULL && $row['user_id'] == $_SESSION['user_id']) {
            $title = $row['title'];
            $description = $row['description'];
            $series_id = $_GET['series_id'];
        }
        else {
            echo '<p>Error: There was a problem accessing your series.</p>';
        }
        
        mysqli_close($dbc);
    }
    
?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <h3 class="text-center"><?php echo $title; ?></h3>
        <div class="form-group">
            <label for="title" class="control-label col-sm-2">Title:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" value="<?php if (!empty($title)) echo $title; ?>" />
            </div>
        </div>
        <div class="form-group">
            <label for="bio" class="control-label col-sm-2">Description:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description"><?php if (!empty($description)) echo $description; ?></textarea><br />
            </div>
        </div>
        <input type="hidden" name="series_id" value="<?php if (!empty($series_id)) echo $series_id; ?>" />
        <span class="centerButton">
            <input type="submit" value="Save Series" class="btn btn-primary" name="submit" />
        </span>
    </form>
</body>
</html>