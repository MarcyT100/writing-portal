<?php
    require_once('connectvars.php');
    
    class Character {
        // Variables
        private $first_name;
        private $last_name;
        private $middle_name;
        private $nick_name;
        private $alias;
        private $gender;
        private $age;
        private $motivation;
        private $occupation;
        private $eye_color;
        private $hair_color;
        private $height;
        private $character_id;
        
        // Setters
        public function setFirst_name($first_name) {
            $this->first_name = $first_name;
        }
        
        public function setLast_name($last_name) {
            $this->last_name = $last_name;
        }
        
        public function setMiddle_name($middle_name) {
            $this->middle_name = $middle_name;
        }
        
        public function setNick_name($nick_name) {
            $this->nick_name = $nick_name;
        }
        
        public function setAlias($alias) {
            $this->alias = $alias;
        }
        
        public function setGender($gender) {
            $this->gender = $gender;
        }
        
        public function setAge($age) {
            $this->age = $age;
        }
        
        public function setMotivation($motivation) {
            $this->motivation = $motivation;
        }
        
        public function setOccupation($occupation) {
            $this->occupation = $occupation;
        }
        
        public function setEye_color($eye_color) {
            $this->eye_color = $eye_color;
        }
        
        public function setHair_color($hair_color) {
            $this->hair_color = $hair_color;
        }
        
        public function setHeight($height) {
            $this->height = $height;
        }
        
        public function setOther_appearance($other_appearance) {
            $this->other_appearance = $other_appearance;
        }
        
        public function setCharacter_id($character_id) {
            $this->character_id = $character_id;
        }
        
        // Getters
        public function getFirst_name() {
            return $this->first_name;
        }
        
        public function getLast_name() {
            return $this->last_name;
        }
        
        public function getMiddle_name() {
            return $this->middle_name;
        }
        
        public function getNick_name() {
            return $this->nick_name;
        }
        
        public function getAlias() {
            return $this->alias;
        }
        
        public function getGender() {
            return $this->gender;
        }
        
        public function getAge() {
            return $this->age;
        }
        
        public function getMotivation() {
            return $this->motivation;
        }
        
        public function getOccupation() {
            return $this->occupation;
        }
        
        public function getEye_color() {
            return $this->eye_color;
        }
        
        public function getHair_color() {
            return $this->hair_color;
        }
        
        public function getHeight() {
            return $this->height;
        }
        
        public function getOther_appearance() {
            return $this->other_appearance;
        }
        
        public function getCharacter_id() {
            return $this->character_id;
        }
        
        // The purpose of this function is to run an update query to update character information
        public function updateCharacter() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            // If there is an age, update it with the age. Otherwise omit the age.
            if (isset($age)) {
                $query = "UPDATE character_info SET first_name = '$this->first_name', last_name = '$this->last_name', middle_name = '$this->middle_name', nick_name = '$this->nick_name', alias = '$this->alias', gender = '$this->gender', age = '$this->age', motivation = '$this->motivation', occupation = '$this->occupation', eye_color = '$this->eye_color', hair_color = '$this->hair_color', height = '$this->height', other_appearance = '$this->other_appearance' WHERE character_id = '$this->character_id'";
            }
            else {
                $query = "UPDATE character_info SET first_name = '$this->first_name', last_name = '$this->last_name', middle_name = '$this->middle_name', nick_name = '$this->nick_name', alias = '$this->alias', gender = '$this->gender', motivation = '$this->motivation', occupation = '$this->occupation', eye_color = '$this->eye_color', hair_color = '$this->hair_color', height = '$this->height', other_appearance = '$this->other_appearance' WHERE character_id = '$this->character_id'";
            }
            
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to display information about the current character
        public function displayCharacter($row) {
            // Display full name at the top of the page
            $display_string = '<h3 class="text-center">';
            if(!empty($row['first_name'])) {
                $display_string .= $row['first_name'] . ' ';
            }
            if(!empty($row['nick_name'])) {
                $display_string .= '"' . $row['nick_name'] . '" ';
            }
            if(!empty($row['middle_name'])) {
                $display_string .= $row['middle_name'] . ' ';
            }
            if(!empty($row['last_name'])) {
                $display_string .= $row['last_name'];
            }
            $display_string .= '</h3>';
            
            $display_string .= '<h3 class="text-center lead">by <a href="viewuser.php?user_id=' . $row['user_id'] . '">' . $row['username'] . '</a></h3>';
            
            $display_string .= "<section class='basicInfo'>";
            
            // Display all books the character appears in
            $display_string .= $this->displayBooks($row['character_id']);
            
            $display_string .= "</section>";
            $display_string .= "<section class='bigInfo'>";
            
            // Display remaining character information
            if (!empty($row['alias'])) {
                $display_string .= "<p><b>Alias:</b> " . $row['alias'] . "</p>";
            }
            
            if (!empty($row['gender'])) {
                if ($row['gender'] == 'M') {
                    $display_string .= "<p><b>Gender:</b> Male</p>";
                } else if ($row['gender'] == 'F') {
                    $display_string .= "<p><b>Gender:</b> Female</p>";
                } else {
                    // Do nothing. This is as if it were blank
                }
            }
            
            if (!empty($row['age'])) {
                $display_string .= "<p><b>Age:</b> " . $row['age'] . "</p>";
            }
            
            if (!empty($row['motivation'])) {
                $display_string .= "<p><b>Motivation:</b> " . $row['motivation'] . "</p>";
            }
            
            if (!empty($row['occupation'])) {
                $display_string .= "<p><b>Occupation:</b> " . $row['occupation'] . "</p>";
            }
            
            if (!empty($row['eye_color'])) {
                $display_string .= "<p><b>Eye Color:</b> " . $row['eye_color'] . "</p>";
            }
            
            if (!empty($row['hair_color'])) {
                $display_string .= "<p><b>Hair Color:</b> " . $row['hair_color'] . "</p>";
            }
            
            if (!empty($row['height'])) {
                $display_string .= "<p><b>Height:</b> " . $row['height'] . "</p>";
            }
            
            if (!empty($row['other_appearance'])) {
                $display_string .= "<p><b>Other Appearance:</b> " . $row['other_appearance'] . "</p>";
            }
            
            $display_string .= "</section>";
        
            return $display_string;
        }
        
        // The purpose of this function is to display all books the character is in
        public function displayBooks($character_id) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $book_query = "SELECT title, book_id FROM book_info INNER JOIN book_character_linking_table USING (book_id) WHERE character_id = '" . $character_id . "' ORDER BY title";
            $result = mysqli_query($dbc, $book_query);
            
            $display_string = "<h4>Books</h4>";
            if (mysqli_num_rows($result) > 0) {
                while ($item = mysqli_fetch_array($result)) {
                    $display_string .= "<p><a href='viewbook.php?book_id=" . $item['book_id'] . "'>" . $item['title'] . "</a>";
                }
            }
            
            mysqli_close($dbc);
            return $display_string;
        }
        
        // The purpose of this function is to add a new character to the database
        public function addCharacter() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "INSERT INTO character_info (first_name, user_id) VALUES ('New Character', " . $_SESSION['user_id'] . ")";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to delete the current character from the database
        public function deleteCharacter() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $query = "DELETE FROM character_info WHERE character_id='$this->character_id'";
            mysqli_query($dbc, $query);
            
            // Delete additional character (if it exists)
            $query = "DELETE FROM character_add_info WHERE character_id='$this->character_id'";
            mysqli_query($dbc, $query);
            
            mysqli_close($dbc);
        }
        
    }
?>
