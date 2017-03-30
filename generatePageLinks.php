<?php
    // Constants
    $RESULTS_PER_PAGE = 10;
    
    // Variables
    $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $skip = (($cur_page - 1) * $RESULTS_PER_PAGE);
    
    // The purpose of this fuction is to build navigational links
    function generate_page_links($cur_page, $num_pages) {
        // Start with empty string
        $page_links = '';
        
        // If this is not the first page, create previous link. Otherwise, display "<- " without link
        if ($cur_page > 1) {
            $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page - 1) . '"><-</a> ';
        }
        else {
            $page_links .= '<- ';
        }
        
        // Loop through pages to create page links
        for ($i = 1; $i <= $num_pages; $i++) {
            if ($cur_page == $i) {
                // If this is the current page, just display number without link
                $page_links .= ' ' . $i;
            }
            else {
                // Otherwise, create link
                $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . '"> ' . $i . '</a> ';
            }
        }
        
        // If this is not the last page, create next link. Otherwise, display " ->" without link
        if ($cur_page < $num_pages) {
            $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page + 1) . '">-></a> ';
        }
        else {
            $page_links .= ' ->';
        }
        
        return $page_links;
    }
?>