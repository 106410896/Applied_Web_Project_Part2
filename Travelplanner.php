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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Personalised Travel Planner</title>

    <link rel="stylesheet" href="styles/TravelPlanner.css">
</head>

<body>
```
<?php require_once 'nav.inc'; ?>  loads nav file 

<main class="travel-container">

    <section class="travel-hero">
        <h1>Discover Your Next Destination</h1>

        <p>
            Explore destinations, compare daily costs,
            and find the best time to travel.  
        </p>
 </section>

    <section class="search-section">  // New section created for searching destinations 
        <form method="GET" action="Travelplanner.php">

            <label for="search">Search destinations</label>

            <input
                type="search"
                id="search"
                name="search"
                placeholder="Enter a destination or country"
                value="<?= escapeHTML($search) ?>"
            >
            


            
