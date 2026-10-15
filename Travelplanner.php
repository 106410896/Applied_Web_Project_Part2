<?php
require_once 'settings.php'; //connect to settings php and database 

require_once 'Travelplanner_functions.inc';  //load the funcitons used by Travel planner

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');  // Get Search and Category values from the URL

$allowedCategories = [   // Categories or options available in database
    'Beach',
    'City',
    'Adventure',
    'Culture'
];

if (!in_array($category, $allowedCategories, true)) {      // Checking that selected category is valid or not 
    $category = '';
}

$search = substr($search, 0, 10000); // Limit the search input

$destinations = getdestinations( $conn,
    $search,
    $category  );  // Retrieve matching destinations from MySQL

    function escapeHTML($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>  // Function escape html created tht converts special characters into safe html representations