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
    require_once('appvars.php');
    require_once('Character.php');
    
    if (!isset($_SESSION['user_id'])) {
        echo 'You must be <a href="login.php">logged in</a> to access this page.</p>';
        exit();
    }
    
    // Connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        // Get character info from form
        $first_name = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
        $middle_name = mysqli_real_escape_string($dbc, trim($_POST['middle_name']));
        $last_name = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
        $nick_name = mysqli_real_escape_string($dbc, trim($_POST['nick_name']));
        $alias = mysqli_real_escape_string($dbc, trim($_POST['alias']));
        $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
        $age = mysqli_real_escape_string($dbc, trim($_POST['age']));
        $motivation = mysqli_real_escape_string($dbc, trim($_POST['motivation']));
        $occupation = mysqli_real_escape_string($dbc, trim($_POST['occupation']));
        $eye_color = mysqli_real_escape_string($dbc, trim($_POST['eye_color']));
        $hair_color = mysqli_real_escape_string($dbc, trim($_POST['hair_color']));
        $height = mysqli_real_escape_string($dbc, trim($_POST['height']));
        $other_appearance = mysqli_real_escape_string($dbc, trim($_POST['other_appearance']));
        $error = false;
        $character_id = mysqli_real_escape_string($dbc, trim($_POST['character_id']));
        
        $new_character = new Character;
        $new_character->setFirst_name($first_name);
        $new_character->setMiddle_name($middle_name);
        $new_character->setLast_name($last_name);
        $new_character->setNick_name($nick_name);
        $new_character->setAlias($alias);
        $new_character->setGender($gender);
        $new_character->setAge($age);
        $new_character->setMotivation($motivation);
        $new_character->setOccupation($occupation);
        $new_character->setEye_color($eye_color);
        $new_character->setHair_color($hair_color);
        $new_character->setHeight($height);
        $new_character->setOther_appearance($other_appearance);
        $new_character->setCharacter_id($character_id);
            
        // Update character data in the database
        $new_character->updateCharacter();

        mysqli_close($dbc);
        
        // Return user to viewcharacter.php
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewcharacter.php?character_id=' . $character_id;
        header('Location: ' . $return_url);
        
    }
    else {
        // Get character info
        $query = "SELECT first_name, middle_name, last_name, nick_name, alias, gender, age, motivation, occupation, eye_color, hair_color, height, other_appearance, user_id FROM character_info WHERE character_id = '" . $_GET['character_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        // If query is sucsessful and the user_ids match, set variables from the query
        if ($row != NULL && $row['user_id'] == $_SESSION['user_id']) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $middle_name = $row['middle_name'];
            $nick_name = $row['nick_name'];
            $alias = $row['alias'];
            $gender = $row['gender'];
            $age = $row['age'];
            $motivation = $row['motivation'];
            $occupation = $row['occupation'];
            $eye_color = $row['eye_color'];
            $hair_color = $row['hair_color'];
            $height = $row['height'];
            $other_appearance = $row['other_appearance'];
            $character_id = $_GET['character_id'];
        }
    }
    
?>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <h3 class="text-center"><?php echo $first_name . " " . $last_name; ?></h3>
            <div class="form-group">
                <label for="first_name" class="control-label col-sm-2">First Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" value="<?php if (!empty($first_name)) echo $first_name; ?>" />                
                </div>
            </div>
            <div class="form-group">
                <label for="middle_name" class="control-label col-sm-2">Middle Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="middle_name" value="<?php if (!empty($middle_name)) echo $middle_name; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="last_name" class="control-label col-sm-2">Last Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" value="<?php if (!empty($last_name)) echo $last_name; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="nick_name" class="control-label col-sm-2">Nickname:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nick_name" value="<?php if (!empty($nick_name)) echo $nick_name; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="alias" class="control-label col-sm-2">Alias:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="alias" value="<?php if (!empty($alias)) echo $alias; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="age" class="control-label col-sm-2">Age:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="age" value="<?php if (!empty($age)) echo $age; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="control-label col-sm-2">Gender:</label>
                <div class="col-sm-10">
                    <select name="gender" class="form-control">
                        <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
                        <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="motivation" class="control-label col-sm-2">Motivation:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="motivation" value="<?php if (!empty($motivation)) echo $motivation; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="occupation" class="control-label col-sm-2">Occupation:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="occupation" value="<?php if (!empty($occupation)) echo $occupation; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="eye_color" class="control-label col-sm-2">Eye Color:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="eye_color" value="<?php if (!empty($eye_color)) echo $eye_color; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="hair_color" class="control-label col-sm-2">Hair Color:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="hair_color" value="<?php if (!empty($hair_color)) echo $hair_color; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="height" class="control-label col-sm-2">Height:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="height" value="<?php if (!empty($height)) echo $height; ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="other_appearance" class="control-label col-sm-2">Other Appearance:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="other_appearance"><?php if (!empty($other_appearance)) echo $other_appearance; ?></textarea><br />
                </div>
            </div>
            <input type="hidden" name="character_id" value="<?php if (!empty($character_id)) echo $character_id; ?>" />
        <span class="centerButton">
            <input type="submit" value="Save Character" class="btn btn-primary" name="submit" />
        </span>
    </form>
</body>
</html>
