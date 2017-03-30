<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- View Book</title>
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
    require_once('Book.php');
    
    // Instantiate object 
    $new_book = new Book;
    // Set book id from GET
    $new_book->setBook_id($_GET['book_id']);
    
    // Get book info
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Query database for book information
    $query = "SELECT title, description, genre, series_id, username, user_id FROM book_info INNER JOIN user_info USING (user_id) WHERE book_id = '" . $_GET['book_id'] . "'";
    $data = mysqli_query($dbc, $query);
    
    // Continue only if there is only one row of data
    if (mysqli_num_rows($data) == 1) {
        // Display series info
        $row = mysqli_fetch_array($data);
        // Set user_id from query
        $user_id = $row['user_id'];
        
        // Display book information
        echo $new_book->displayBook($row);
    }
    
    // Display characters in book
    echo $new_book->displayCharacters();
    
    // If associated user is logged in, allow them to go to bookcharacters.php to add characters to book
    if ($_SESSION['user_id'] == $user_id) {
        echo "<p class='small'><a href='bookcharacters.php?book_id=" . $_GET['book_id']  . "'>Add characters?</a>";
    }
    
    echo "</section>";
    
    // Is associated user is logged in, allow user to edit book or delete book
    if ($_SESSION['user_id'] == $user_id) {
        echo "<section class='userInfo'";
        echo '<p><a href="editbook.php?book_id=' . $_GET['book_id'] . '">Edit book</a>';
        echo ' &#8226; ';
        echo '<a href="deleteentry.php?book_id=' . $_GET['book_id'] . '&amp;type=book">Delete book</a></p>';
        echo "</section>";
    }
    
?>
</body>
</html>