<?php
    require_once('startsession.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Edit Book</title>
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
    require_once('Book.php');
    
    if (!isset($_SESSION['user_id'])) {
        echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
        exit();
    }
    
    // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        // Get book info from form
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
        $genre = mysqli_real_escape_string($dbc, trim($_POST['genre']));
        $series = mysqli_real_escape_string($dbc, trim($_POST['series']));
        $book_id = mysqli_real_escape_string($dbc, trim($_POST['book_id']));
        
        // Instantiate object
        $new_book = new Book;
        
        // Set object variables
        $new_book->setTitle($title);
        $new_book->setDescription($description);
        $new_book->setGenre($genre);
        $new_book->setSeries($series);
        $new_book->setBook_id($book_id);
        
        // Add information to the database
        $new_book->updateBook();
        
        mysqli_close($dbc);
        
        // Return user to viewbook.php
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewbook.php?book_id=' . $book_id;
        header('Location: ' . $return_url);
    }
    else {
        // Get book info
        $query = "SELECT title, description, genre, series_id, user_id FROM book_info WHERE book_id = '" . $_GET['book_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        // Set variables if query is sucsessful. Otherwise, display error message.
        if ($row != NULL && $row['user_id'] == $_SESSION['user_id']) {
            $title = $row['title'];
            $description = $row['description'];
            $genre = $row['genre'];
            $series = $row['series_id'];
            $book_id = $_GET['book_id'];
        }
        else {
            echo '<p>Error: There was a problem accessing your book.</p>';
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
        <div class="form-group">
            <label for="genre" class="control-label col-sm-2">Genre:</label>
            <div class="col-sm-10">
                <select name="genre">
                    <option value="ADVE" <?php if (!empty($genre) && $genre == 'ADVE') echo 'selected = "selected"'; ?>>Adventure</option>
                    <option value="FANT" <?php if (!empty($genre) && $genre == 'FANT') echo 'selected = "selected"'; ?>>Fantasy</option>
                    <option value="HFIC" <?php if (!empty($genre) && $genre == 'HFIC') echo 'selected = "selected"'; ?>>Historical Fiction</option>
                    <option value="HORR" <?php if (!empty($genre) && $genre == 'HORR') echo 'selected = "selected"'; ?>>Horror</option>
                    <option value="RFIC" <?php if (!empty($genre) && $genre == 'RFIC') echo 'selected = "selected"'; ?>>Realistic Fiction</option>
                    <option value="MYST" <?php if (!empty($genre) && $genre == 'MYST') echo 'selected = "selected"'; ?>>Mystery</option>
                    <option value="THRI" <?php if (!empty($genre) && $genre == 'THRI') echo 'selected = "selected"'; ?>>Thriller</option>
                    <option value="ROMA" <?php if (!empty($genre) && $genre == 'ROMA') echo 'selected = "selected"'; ?>>Romance</option>
                    <option value="HUMO" <?php if (!empty($genre) && $genre == 'HUMO') echo 'selected = "selected"'; ?>>Humor</option>
                    <option value="SFIC" <?php if (!empty($genre) && $genre == 'SFIC') echo 'selected = "selected"'; ?>>Science Fiction</option>
                    <option value="YOAD" <?php if (!empty($genre) && $genre == 'YOAD') echo 'selected = "selected"'; ?>>Young Adult</option>
                    <option value="OTHE" <?php if (!empty($genre) && $genre == 'OTHE') echo 'selected = "selected"'; ?>>Other</option>
                </select>
            </div>
        </div>
        <?php
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "SELECT series_id, title FROM series_info WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY title";
            $data = mysqli_query($dbc, $query);
            
            if (mysqli_num_rows($data) > 0) {
        ?>
        <div class="form-group">
            <label for="series" class="control-label col-sm-2">Series:</label>
            <div class="col-sm-10">
                <select name="series">
                    <option value="">None</option>
        <?php
            while ($row = mysqli_fetch_array($data)) {
                echo '<option value="' . $row['series_id'] . '"';
                
                if (!empty($series) && $series == $row['series_id']) {
                    echo 'selected = "selected"';
                }
                
                echo '>' . $row['title'] . '</option>';
            }
        ?>
                </select>
            </div>
        </div>
        <?php
            }
            
        mysqli_close($dbc);       
        ?>

        <input type="hidden" name="book_id" value="<?php if (!empty($book_id)) echo $book_id; ?>" />
        <span class="centerButton">
            <input type="submit" value="Save Book" class="btn btn-primary" name="submit" />
        </span>
    </form>

</body>
</html>