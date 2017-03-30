<?php
    require_once('connectvars.php');
    
    class Characteradd {
        // Variables
        private $alignment;
        private $likes;
        private $dislikes;
        private $friends;
        private $enemies;
        private $personality;
        private $backstory;
        private $family;
        private $character_add_id;
        
        // Setters
        public function setAlignment($alignment) {
            $this->alignment = $alignment;
        }
        
        public function setLikes($likes) {
            $this->likes = $likes;
        }
        
        public function setDislikes($dislikes) {
            $this->dislikes = $dislikes;
        }
        
        public function setFriends($friends) {
            $this->friends = $friends;
        }
        
        public function setEnemies($enemies) {
            $this->enemies = $enemies;
        }
        
        public function setPersonality($personality) {
            $this->personality = $personality;
        }
        
        public function setBackstory($backstory) {
            $this->backstory = $backstory;
        }
        
        public function setFamily($family) {
            $this->family = $family;
        }
        
        public function setCharacter_add_id($character_add_id) {
            $this->character_add_id = $character_add_id;
        }
        
        // Getters
        public function getAlignment() {
            return $this->alignment;
        }
        
        public function getLikes() {
            return $this->likes;
        }
        
        public function getDislikes() {
            return $this->dislikes;
        }
        
        public function getFriends() {
            return $this->friends;
        }
        
        public function getEnemies() {
            return $this->enemies;
        }
        
        public function getPersonality() {
            return $this->personality;
        }
        
        public function getBackstory() {
            return $this->backstory;
        }
        
        public function getFamily() {
            return $this->family;
        }
        
        public function getCharacter_add_id() {
            return $this->character_add_id;
        }
        
        // The purpose of this function is to run an update query to update the additional character information
        public function updateCharacter_add() {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "UPDATE character_add_info SET alignment = '$this->alignment', likes = '$this->likes', dislikes = '$this->dislikes', friends = '$this->friends', enemies = '$this->enemies', personality = '$this->personality', backstory = '$this->backstory', family = '$this->family' WHERE character_add_id = '" . $this->character_add_id . "'";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
        // The purpose of this function is to display the current character's information
        public function displayCharacter_add($row) {
            // The character's full name appears along the top
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
            
            // Display remaining additional character information
            $display_string .= "<section class='bigInfo'>";
            
            if (!empty($row['alignment'])) {
                $display_string .= "<p><b>Alignment:</b> ";
                
                // Alignment switch statement
                switch($row['alignment']) {
                case "lg":
                    $display_string .= "Lawful Good";
                    break;
                case "ln":
                    $display_string .= "Lawful Neutral";
                    break;
                case "le":
                    $display_string .= "Lawful Evil";
                    break;
                case "ng":
                    $display_string .= "Neutral Good";
                    break;
                case "tn":
                    $display_string .= "True Neutral";
                    break;
                case "ne":
                    $display_string .= "Neutral Evil";
                    break;
                case "cg":
                    $display_string .= "Chaotic Good";
                    break;
                case "cn":
                    $display_string .= "Chaotic Neutral";
                    break;
                case "ce":
                    $display_string .= "Chaotic Evil";
                    break;
                default:
                    // Do nothing
                    break;
                }
                $display_string .= "</p><br />";
            }
            
            if (!empty($row['likes'])) {
                $display_string .= "<p><b>Likes:</b> " . $row['likes'] . "</p><br/ >";
            }
            
            if (!empty($row['dislikes'])) {
                $display_string .= "<p><b>Dislikes:</b> " . $row['dislikes'] . "</p><br/ >";
            }
            
            if (!empty($row['friends'])) {
                $display_string .= "<p><b>Friends:</b> " . $row['friends'] . "</p><br/ >";
            }
            
            if (!empty($row['enemies'])) {
                $display_string .= "<p><b>Enemies:</b> " . $row['enemies'] . "</p><br/ >";
            }
            
            if (!empty($row['personality'])) {
                $display_string .= "<p><b>Personality:</b> " . $row['personality'] . "</p><br/ >";
            }
            
            if (!empty($row['backstory'])) {
                $display_string .= "<p><b>Backstory:</b> " . $row['backstory'] . "</p><br/ >";
            }
            
            if (!empty($row['family'])) {
                $display_string .= "<p><b>Family:</b> " . $row['family'] . "</p><br/ >";
            }
            
            $display_string .= "</section>";
            
            $display_string .= "<section class='userInfo'>";
            // Return to character page
            $display_string .= "<p><a href='viewcharacter.php?character_id=" . $row['character_id'] . "'>Return to character</a></p>";
       
            return $display_string;
        }
        
        // The purpose of this function is to add a new additional character to the database
        public function addCharacter_add($character_id) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $query = "INSERT INTO character_add_info (character_id, user_id) VALUES ($character_id, " . $_SESSION['user_id'] . ")";
            mysqli_query($dbc, $query);
            mysqli_close($dbc);
        }
        
    }
?>