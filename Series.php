<?php
    require_once('connectvars.php');
    
    class Series {
        // Variables
        private $title;
        private $description;
        private $series_id;
        
        // Setters
        public function setTitle($title) {
            $this->title = $title;
        }
        
        public function setDescription($description) {
            $this->description = $description;
        }
        
        public function setSeries_id($series_id) {
            $this->series_id = $series_id;
        }
        
        // Getters
        public function getTitle() {
            return $this->title;
        }
        
        public function getDescription() {
            return $this->description;
        }
        
        public function getSeries_id() {
            return $this->series_id;
        }
        
        // The purpose of this function is to display information about the current series based on a query row
        public function displaySeries($row) {
            // Display title and user
            $display_string .= '<h2 class="text-center">' . $row['title'] . '</h2>';
            $display_string .= '<h2 class="text-center lead">by <a href="viewuser.php?user_id=' . $row['user_id'] . '">' . $row['username'] . '</a></h2>';
            $display_string .= '<br />';
            
            // If it exists, display description
            if (!empty($row['description'])) {
                $display_string .= "<section class='halfDescription'>";
                $display_string .= '<p><span class="lead">Description: </span>' . $row['description'] . '</p>';
                $display_string .= '</section>';
            }
            
            return $display_string;
        }
        
        // The purpose of this function is to update the series entry in the database
        public function updateSeries() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "UPDATE series_info SET title = '$this->title', description = '$this->description' WHERE series_id = '$this->series_id'";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to display books associated with the series
        public function displayBooks() {
            $display_string = "";
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "SELECT book_id, title FROM book_info WHERE series_id = '$this->series_id' ORDER BY title";
            $data = mysqli_query($dbc, $query);
            $total = mysqli_num_rows($data);
    
            $display_string .= "<section class='halfDescription'>";
            $display_string .= "<h4>Books</h4>";
            
            // If there are no books, display "No books found". Otherwise, display each book with link
            if ($total == 0) {
                $display_string .= '<p>No books found</p>';
            }
            else {
                $display_string .= "<table>";
                
                // Display every book with title and link
                while ($row = mysqli_fetch_array($data)) {
                    $display_string .= "<tr><td>";
                    $display_string .= "<a href='viewbook.php?book_id=" . $row['book_id'] . "'>" . $row['title'] . "</a>";
                    $display_string .= "</td></tr>";
                }
                
                $display_string .= "</table>";
            }
    
            mysqli_close($dbc);
            return $display_string;
        }
        
        // The purpose of this function is to display every character associated with this series
        public function displayCharacters() {
            $display_string = "";
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "SELECT character_id, first_name, last_name, nick_name FROM character_info INNER JOIN book_character_linking_table USING (character_id) INNER JOIN book_info USING (book_id) INNER JOIN series_info USING (series_id) WHERE series_id = '$this->series_id' GROUP BY character_id ORDER BY last_name, first_name";
            $data = mysqli_query($dbc, $query);
            $total = mysqli_num_rows($data);
    
            $display_string .="<h4>Characters</h4>";
    
            // If there are no characters, display "No characters found". Otherwise, display each character
            if ($total == 0) {
                $display_string .= '<p>No characters found</p>';
            }
            else {
                $display_string .= "<table>";
                
                // Display each character associated with this series with link
                while ($row = mysqli_fetch_array($data)) {
                    $display_string .= "<tr><td>";
                    
                    // If there is no nickname, display first and last name. If there is, display first, nickname, and last name.
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
            $display_string .= "</section>";
            mysqli_close($dbc);
            return $display_string;
    }
    
    // The purpose of this function is to add a series to the database
    public function addSeries() {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "INSERT INTO series_info (title, user_id) VALUES ('New Series', " . $_SESSION['user_id'] . ")";
        mysqli_query($dbc, $query);
        mysqli_close($dbc);
    }
    
    // The purpose of this function is to delete the current series from the database
    public function deleteSeries() {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "DELETE FROM series_info WHERE series_id = '$this->series_id'";
        mysqli_query($dbc, $query);
        mysqli_close($dbc);
    }   
}

?>