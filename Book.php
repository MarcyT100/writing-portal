<?php
    require_once('connectvars.php');
    
    class Book {
        // Variables
        private $title;
        private $description;
        private $genre;
        private $series;
        private $book_id;
        
        // Setters
        public function setTitle($title) {
            $this->title = $title;
        }
        
        public function setDescription($description) {
            $this->description = $description;
        }
        
        public function setGenre($genre) {
            $this->genre = $genre;
        }
        
        public function setSeries($series) {
            $this->series = $series;
        }
        
        public function setBook_id($book_id) {
            $this->book_id = $book_id;
        }
        
        // Getters
        public function getTitle() {
            return $this->title;
        }
        
        public function getDescription() {
            return $this->description;
        }
        
        public function getGenre($genre) {
            return $this->genre;
        }
        
        public function getSeries($series) {
            return $this->series;
        }
        
        public function getBook_id($book_id) {
            return $this->book_id;
        }
        
        // The purpose of this function is to run an update query on book_info to update book data
        public function updateBook() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "UPDATE book_info SET title = '$this->title', description = '$this->description', genre = '$this->genre' WHERE book_id = '$this->book_id'";
            echo $query;
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to display book information from a select query
        public function displayBook($row) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $display_string = '<h3 class="text-center">' . $row['title'] . '</h3>';
            $display_string .= '<h3 class="text-center lead">by <a href="viewuser.php?user_id=' . $row['user_id'] . '">' . $row['username'] . '</a></h3>';
        
            $display_string .= "<section class='halfDescription'>";
        
            if (!empty($row['genre'])) {
                $display_string .= "<p><b>Genre:</b> ";
                
                // Genre switch statement
                switch($row['genre']) {
                case "ADVE":
                    $display_string .= "Adventure";
                    break;
                case "FANT":
                    $display_string .= "Fantasy";
                    break;
                case "HFIC":
                    $display_string .= "Historical Fiction";
                    break;
                case "HORR":
                    $display_string .= "Horror";
                    break;
                case "RFIC":
                    $display_string .= "Realistic Fiction";
                    break;
                case "MYST":
                    $display_string .= "Mystery";
                    break;
                case "THRI":
                    $display_string .= "Thriller";
                    break;
                case "ROMA":
                    $display_string .= "Romance";
                    break;
                case "HUMO":
                    $display_string .= "Humor";
                    break;
                case "SFIC":
                    $display_string .= "Science Fiction";
                    break;
                case "YOAD":
                    $display_string .= "Young Adult";
                    break;
                case "OTHE":
                    $display_string .= "Other";
                    break;
                default:
                    $display_string .= "Other";
                    break;
                }
                
                $display_string .= "</p>";
            }
            
            // Display series title with link based on series_id
            if (!empty($row['series_id'])) {
                $series_query = "SELECT title FROM series_info WHERE series_id = '" . $row['series_id'] . "'";
                $result = mysqli_query($dbc, $series_query);
                $item = mysqli_fetch_array($result);
                $display_string .= "<p><b>Series:</b> <a href='viewseries.php?series_id=" . $row['series_id'] . "'>" . $item['title'] . "</a></p>";
            }
            
            if (!empty($row['description'])) {
                $display_string .= '<p><span class="lead">Description: </span>' . $row['description'] . '</p>';
            }
            
            $display_string .= "</section>";
            mysqli_close($dbc);
            return $display_string;
        }
        
        // The purpose of this function is to display every character who is associated with any book in this series
        public function displayCharacters() {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT character_id, first_name, last_name, nick_name FROM character_info INNER JOIN book_character_linking_table USING (character_id) INNER JOIN book_info USING (book_id) WHERE book_id = '" . $_GET['book_id'] . "' ORDER BY last_name, first_name";
        $data = mysqli_query($dbc, $query);
        $total = mysqli_num_rows($data);
        
        $display_string = "<section class='halfDescription'>";
        $display_string .= "<h4>Characters</h4>";
        
        if ($total == 0) {
            $display_string .= '<p>No characters found</p>';
        }
        else {
            
            $display_string .= "<table>";
            
            while ($row = mysqli_fetch_array($data)) {
                $display_string .= "<tr><td>";
                // Display the viewcharacter links differently based on whether or not the character has a nickname
                if ($row['nick_name'] == null) {
                    $display_string .= "<a href='viewcharacter.php?character_id=" . $row['character_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</a>";
                }
                else {
                    $display_string .= "<a href='viewcharacter.php?character_id=" . $row['character_id'] . "'>" . $row['first_name'] . ' "' . $row['nick_name'] . '" ' . $row['last_name'] . "</a>";
                }
                $display_string .= "</td></tr>";
            }
            
            $display_string .= "</table>";
        }
        mysqli_close($dbc);
        return $display_string;
        }
        
        // The purpose of this function is to add a new book to the database
        public function addBook() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "INSERT INTO book_info (title, user_id) VALUES ('New Book', " . $_SESSION['user_id'] . ")";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to delete the current book from the database
        public function deleteBook() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "DELETE FROM book_info WHERE book_id = '$this->book_id'";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }  
    }
?>