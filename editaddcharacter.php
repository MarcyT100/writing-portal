<?php
    require_once('startsession.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal -- Edit Character</title>
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
    require_once('Characteradd.php');
    
    if (!isset($_SESSION['user_id'])) {
        echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
        exit();
    }
    
     // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        // Get character info from form
        $alignment = mysqli_real_escape_string($dbc, trim($_POST['alignment']));
        $likes = mysqli_real_escape_string($dbc, trim($_POST['likes']));
        $dislikes = mysqli_real_escape_string($dbc, trim($_POST['dislikes']));
        $friends = mysqli_real_escape_string($dbc, trim($_POST['friends']));
        $enemies = mysqli_real_escape_string($dbc, trim($_POST['enemies']));
        $personality = mysqli_real_escape_string($dbc, trim($_POST['personality']));
        $backstory = mysqli_real_escape_string($dbc, trim($_POST['backstory']));
        $family = mysqli_real_escape_string($dbc, trim($_POST['family']));
        $character_add_id = mysqli_real_escape_string($dbc, trim($_POST['character_add_id']));
        
        // Instantiate new object
        $new_add_character = new Characteradd;
        
        // Set object variables
        $new_add_character->setAlignment($alignment);
        $new_add_character->setLikes($likes);
        $new_add_character->setDislikes($dislikes);
        $new_add_character->setFriends($friends);
        $new_add_character->setEnemies($enemies);
        $new_add_character->setPersonality($personality);
        $new_add_character->setBackstory($backstory);
        $new_add_character->setFamily($family);
        $new_add_character->setCharacter_add_id($character_add_id);
        
        // Add information to the database
        $new_add_character->updateCharacter_add();
        
        mysqli_close($dbc);
        
        // Return user to viewaddcharacter.php
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewaddcharacter.php?character_add_id=' . $character_add_id;
        header('Location: ' . $return_url);
    }
    else {
        // Get character info
        $query = "SELECT u.user_id, c.first_name, c.last_name, a.alignment, a.likes, a.dislikes, a.friends, a.enemies, a.personality, a.backstory,
                a.family, a.character_add_id FROM user_info AS u INNER JOIN character_info AS c USING (user_id) INNER JOIN character_add_info AS a USING (character_id) WHERE character_add_id = '" . $_GET['character_add_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        // Set variables with data from query if query was sucsessful. Otherwise, display error message.
        if ($row != NULL && $row['user_id'] == $_SESSION['user_id']) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $alignment = $row['alignment'];
            $likes = $row['likes'];
            $dislikes = $row['dislikes'];
            $friends = $row['friends'];
            $enemies = $row['enemies'];
            $personality = $row['personality'];
            $backstory = $row['backstory'];
            $family = $row['family'];
            $character_add_id = $row['character_add_id'];
        }
        else {
            echo '<p>Error: There was a problem accessing your character.</p>';
        }
        mysqli_close($dbc);
        
    }
    
?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <h3 class="text-center"><?php echo $first_name . " " . $last_name; ?></h3>
         <div class="form-group">
                <label for="alignment" class="control-label col-sm-2">Alignment:</label>
                <div class="col-sm-10">
                <select name="alignment" class="form-control">
                    <option value="">None</option>
                    <option value="lg" <?php if (!empty($alignment) && $alignment == 'lg') echo 'selected = "selected"'; ?>>Lawful Good</option>
                    <option value="ln" <?php if (!empty($alignment) && $alignment == 'ln') echo 'selected = "selected"'; ?>>Lawful Neutral</option>
                    <option value="le" <?php if (!empty($alignment) && $alignment == 'le') echo 'selected = "selected"'; ?>>Lawful Evil</option>
                    <option value="ng" <?php if (!empty($alignment) && $alignment == 'ng') echo 'selected = "selected"'; ?>>Neutral Good</option>
                    <option value="tn" <?php if (!empty($alignment) && $alignment == 'tn') echo 'selected = "selected"'; ?>>True Neutral</option>
                    <option value="ne" <?php if (!empty($alignment) && $alignment == 'ne') echo 'selected = "selected"'; ?>>Neutral Evil</option>
                    <option value="cg" <?php if (!empty($alignment) && $alignment == 'cg') echo 'selected = "selected"'; ?>>Chaotic Good</option>
                    <option value="cn" <?php if (!empty($alignment) && $alignment == 'cn') echo 'selected = "selected"'; ?>>Chaotic Neutral</option>
                    <option value="ce" <?php if (!empty($alignment) && $alignment == 'ce') echo 'selected = "selected"'; ?>>Chaotic Evil</option>
                </select><br />
            </div>
        </div>
        <div class="form-group">
            <label for="likes" class="control-label col-sm-2">Likes:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="likes"><?php if (!empty($likes)) echo $likes; ?></textarea><br />
            </div>
        </div>
                <div class="form-group">
            <label for="dislikes" class="control-label col-sm-2">Dislikes:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="dislikes"><?php if (!empty($dislikes)) echo $dislikes; ?></textarea><br />
            </div>
        </div>
                <div class="form-group">
            <label for="friends" class="control-label col-sm-2">Friends:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="friends"><?php if (!empty($friends)) echo $friends; ?></textarea><br />
            </div>
        </div>
                <div class="form-group">
            <label for="enemies" class="control-label col-sm-2">Enemies:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="enemies"><?php if (!empty($enemies)) echo $enemies; ?></textarea><br />
            </div>
        </div>
                <div class="form-group">
            <label for="personality" class="control-label col-sm-2">Personality:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="personality"><?php if (!empty($personality)) echo $personality; ?></textarea><br />
            </div>
        </div>
                <div class="form-group">
            <label for="backstory" class="control-label col-sm-2">Backstory:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="backstory"><?php if (!empty($backstory)) echo $backstory; ?></textarea><br />
            </div>
        </div>
                <div class="form-group">
            <label for="family" class="control-label col-sm-2">Family:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="family"><?php if (!empty($family)) echo $family; ?></textarea><br />
            </div>
        </div>
        <input type="hidden" name="character_add_id" value="<?php if (!empty($character_add_id)) echo $character_add_id; ?>" />
        <span class="centerButton">
            <input type="submit" value="Save Character" class="btn btn-primary" name="submit" />
        </span>
    </form>

</body>
</html>