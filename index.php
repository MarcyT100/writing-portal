<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Writing Portal</title>
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
    
    // Declare search variable
    $search = $_POST['search'];
?>
    
    <h1 class="text-center">Welcome to the Writing Portal</h1>
    
    <span class="introText">
    <h4>About the Character Portal:</h4>
    <p>Welcome to the Character Portal, the best place to share your writing projects and read about others'. With space 
    to explain your books and series and an extensive profile to fill out about your characters, this is a writer's dream. 
    Free and easy to use, there is no reason not to utilize this platform. And sharing is easy. Just send a link to any of 
    your friends or share on social media--no account is necessary to view project information.</p><br />

    <blockquote class="small">"I love the Writing Portal! It makes developing my writing projects AND sharing them with my friends so easy!"
    <br />--Ella Burkley</blockquote>

    <blockquote class="small">"This is the site every writer needs--even if they don't realize it yet. Sharing information about my stories in a central location inspires me to write more, and the character profiles help me think up and keep track of important details about my characters."
    <br />--Jake Reyland</blockquote>

    <blockquote class="small">"The Writing Portal is a dream come true! I just love it so much! It makes writing so much more fun and sharing so much more easy. Everyone needs this! Even if you don't write yet, this site will inspire your creativity."
    <br />--Phoenix Avery</blockquote>
    </span>
    
    <span class="searchBar">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <div class="form-group">
            <label for="search" class="control-label col-sm-2">Search:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="search" value="<?php if (!empty($search)) echo $search;?>" /><br />
            </div>
            <span class="centerButton">
                <input type="submit" value="Search" class="btn btn-primary" name="submit" />
            </span>
        </div>
    </form>
    
<?php
    require_once('generatePageLinks.php');
    require_once('connectvars.php');
    
    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    // Query for all users
    if ($_POST['submit']) {
        $query = "SELECT user_id, username FROM user_info";
        
        // Extract search keywords
        $clean_search = str_replace(", ", ' ', $search);
        $search_words = explode(' ', $clean_search);
        $final_search_words = array();
        
        // If there are search words, create array of each word
        if (count($search_words) > 0) {
            foreach ($search_words as $word) {
                if (!empty($word)) {
                    $final_search_words[] = $word;
                }
            }
        }
        
        // Create where clause with search terms
        $where_list = array();
        if (count($final_search_words) > 0) {
            foreach($final_search_words as $word) {
                $where_list[] = "username LIKE '%$word%'";
            }
        }
        
        // Create clause with 'OR'
        $where_clause = implode(' OR ', $where_list);
        
        // If where clause contains content, append it to query. If not, only append ORDER BY clause
        if (!empty($where_clause)) {
            $query .= " WHERE $where_clause ORDER BY user_id DESC";
        } else {
            $query .= " ORDER BY user_id DESC";
        }
        
    }
    else {
        // If form has not been submitted, query for all users
        $query = "SELECT user_id, username FROM user_info ORDER BY user_id DESC";
    }
    
    // Run query and calculate total and number of pages
    $data = mysqli_query($dbc, $query);
    $total = mysqli_num_rows($data);
    $num_pages = ceil($total / $RESULTS_PER_PAGE);
    
    // Display each page
    $query = $query . " LIMIT $skip, $RESULTS_PER_PAGE";
    $result = mysqli_query($dbc, $query);
    
    echo '<table class="searchResults">';
    
    // Display each username with link
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr><td class="text-center"><a href = "viewuser.php?user_id=' . $row['user_id'] . '">' . $row['username'] . '</a></td></tr>';
    }
    
    echo '</table>';
    
    // If there are multiple pages, generate page links
    if ($num_pages > 1) {
        echo "<br /><p class='text-right'>" . generate_page_links($cur_page, $num_pages) . "</p>";
    }
    
    mysqli_close($dbc);
    
?>
    
    </span>
</body>
</html>