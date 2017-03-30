<?php
    require_once('connectvars.php');
    
    class User {
        // Variables
        private $bio;
        private $gender;
        private $error;
        
        // Setters
        public function setBio($bio) {
            $this->bio = $bio;
        }
        
        public function setGender($gender) {
            $this->gender = $gender;
        }
        
        // Getters 
        public function getBio() {
            return $this->bio;
        }
        
        public function getGender() {
            return $this->gender;
        }
        
        // The purpose of this function is to display user information based on a query row
        public function displayUser($row) {
            $display_string = '<h3 class="text-center">' . $row['username'] . '</h3>';
            $display_string .= "<section class='basicInfo'>";
            
            // If exists, display bio
            if (!empty($row['bio'])) {
                $display_string .= '<p><span class="lead">BIO: </span>' . $row['bio'] . '</p>';
                $display_string .= '<br />';
            }
            
            // If gender is set, display Male for 'M' or Female for 'F'
            if (!empty($row['gender'])) {
                if ($row['gender'] == 'M') {
                    $display_string .= "<p><b>Gender:</b> Male</p>";
                } else if ($row['gender'] == 'F') {
                    $display_string .= "<p><b>Gender:</b> Female</p>";
                } else {
                    // Do nothing. This is as if it were blank
                }
            }
            
            $display_string .= "</section>";
            return $display_string;
        }
        
        // The purpose of this function is to update user information in the database
        public function updateUser() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "UPDATE user_info SET bio = '$this->bio', gender = '$this->gender' WHERE user_id = '" . $_SESSION['user_id'] . "'";
 
            mysqli_query($dbc, $query);
            
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to display every series associated with user
        public function displayAllSeries() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            // Query for all series by user
            $query = "SELECT series_id, title FROM series_info WHERE user_id ='" . $_GET['user_id'] . "' ORDER BY title DESC";
            $data = mysqli_query($dbc, $query);
            
            $display_string = "<section class='moreInfo'>";
            $display_string .= "<h4>Series</h4>";
            
            // If there are series, display them. Otherwise, display "No series found".
            if (mysqli_num_rows($data) > 0) {
                $display_string .= "<table>";
            
                // For every series, display title and link
                while ($row = mysqli_fetch_array($data)) {
                    $display_string .= "<tr><td>";
                    $display_string .= "<a href='viewseries.php?series_id=" . $row['series_id'] . "'>" . $row['title'] . "</a>";
                    $display_string .= "</td></tr>";
                }
            
                $display_string .= "</table>";
            }
            else {
                $display_string .= "<p>No series found</p>";
            }
            
            $display_string .= "</section>";
            
            mysqli_close($dbc);
            
            return $display_string;
        }
        
        // The purpose of this function is to display edit series links for series based on a query row
        public function displaySeries($row) {
            $display_string = "<tr><td>";
            $display_string .= "<a href='editseries.php?series_id=" . $row['series_id'] . "'>" . $row['title'] . "</a>";
            $display_string .= "</td></tr>";
            return $display_string;
        }
        
        // The purpose of this function is to display all characters associated with current user
        public function displayAllCharacters() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            // Query to determine all characters
            $query = "SELECT character_id, first_name, last_name, nick_name FROM character_info WHERE user_id = '" . $_GET['user_id'] . "' ORDER BY last_name, first_name";
            $data = mysqli_query($dbc, $query);
            
            $display_string = "<section class='moreInfo'>";
            $display_string .= "<h4>Characters</h4>";
            
            // If there are characters, display them. Otherwise, display "No characters found".
            if (mysqli_num_rows($data) > 0) {
                $display_string .= "<table>";
                
                // Display each character's name and link
                while ($row = mysqli_fetch_array($data)) {
                    $display_string .= "<tr><td>";
                    
                    // If the character has a nickname, include that in link. Otherwise, do not.
                    if (!empty($row['nick_name'])) {
                        $display_string .= "<a href='viewcharacter.php?character_id=" . $row['character_id'] . "'>" . $row['first_name'] . ' "' . $row['nick_name'] . '" ' . $row['last_name'] . "</a>";
                    }
                    else {
                        $display_string .= "<a href='viewcharacter.php?character_id=" . $row['character_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</a>";
                    }
                    
                    $display_string .= "</td></tr>";
                }
            
                $display_string .= "</table>";
            }
            else {
                $display_string .= "<p>No characters found</p>";
            }
            
            $display_string .= "</section>";
            mysqli_close($dbc);
            return $display_string;
        }
        
        // The purpose of this function is to display character name and editing link based on a row from a query
        public function displayCharacter($row) {
            $display_string = "<tr><td>";
            $display_string .= "<a href='editcharacter.php?character_id=" . $row['character_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</a>";
            $display_string .= "</td></tr>";
            return $display_string;
        }
        
        // The purpose of this function is to display all books associated with current user
        public function displayAllBooks() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            // Query database for every book associated with current user
            $query = "SELECT book_id, title FROM book_info WHERE user_id = '" . $_GET['user_id'] . "' ORDER BY title";
            $data = mysqli_query($dbc, $query);
    
            $display_string = "<section class='moreInfo'>";
            $display_string .= "<h4>Books</h4>";
            
            // If there are books, display them. Otherwise, display "No books found".
            if (mysqli_num_rows($data) > 0) {
            $display_string .= "<table>";
            
            // Display each book's title and link
            while ($row = mysqli_fetch_array($data)) {
                $display_string .= "<tr><td>";
                $display_string .= "<a href='viewbook.php?book_id=" . $row['book_id'] . "'>" . $row['title'] . "</a>";
                $display_string .= "</td></tr>";
            }
            
            $display_string .= "</table>";
            
            }
            else {
                $display_string .= "<p>No books found</p>";
            }
            
            $display_string .= "</section>";
            
            mysqli_close($dbc);
            
            return $display_string;
        }
        
        // The purpose of this function is to display book editing link based on a row from a query
        public function displayBook($row) {
            $display_string = "<tr><td>";
            $display_string .= "<a href='editbook.php?book_id=" . $row['book_id'] . "'>" . $row['title'] . "</a>";
            $display_string .= "</td></tr>";
            return $display_string;
        }
        
        // Display add new link based on type
        public function displayAddLink($type) {
            $display_string = "<span class='small'><a href='addnew.php?type=$type'>Add New</a></span>";
            return $display_string;
        }
    }
?>