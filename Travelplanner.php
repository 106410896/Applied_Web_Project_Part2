
<?php
// Created by Kshitij Shetty 
require_once 'settings.php'; //connect to settings php and database 

require_once __DIR__ . '/Travelplanner_functions.inc';  //load the funcitons used by Travel planner

$search = (isset($_GET['search']) && is_string($_GET['search'])) ? trim($_GET['search']) : '';
$category = (isset($_GET['category']) && is_string($_GET['category'])) ? trim($_GET['category']) : '';  // Get Search and Category values from the URL

$allowedCategories = [   // Categories or options available in database
    'Beach',
    'City',
    'Adventure',
    'Culture'
];

if (!in_array($category, $allowedCategories, true)) {      // Checking that selected category is valid or not 
    $category = '';
}

$search = mb_substr($search, 0, 100); // Limit the search input

$destinations = getdestinations( $conn,
    $search,
    $category  );  // Retrieve matching destinations from MySQL

// Function escape html created tht converts special characters into safe html representations
function escapeHTML($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

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

<?
    //loads nav file 
    php require_once 'nav.inc';  
?>

<!-- Main content of the Page -->
<main class="Travel-Mainlines">

    <section class="travel-user">
        <h1>Discover Your Next Destination</h1>

        <p>
            Explore destinations, compare daily costs,
            and find the best time to travel.  
        </p>
 </section>


<!-- New section created for searching destinations -->
    <section class="search-section">  
        <form method="GET" action="Travelplanner.php">

            <label for="search">Search destinations</label>

            <input
                type="search"
                id="search"
                name="search"
                maxlength="100"
                placeholder="Enter a destination or country"
                value="<?= escapeHTML($search) ?>"
            >

<!-- Destination category dropdown box created with all the categories available in database -->
            <label for="category">Destination category</label> 
            <select id="category" name="category">
                <option value="">All Categories</option>
                <?php foreach ($allowedCategories as $item): ?>
                    <option value="<?= escapeHTML($item) ?>" <?= $item === $category ? 'selected' : '' ?>>
                        <?= escapeHTML($item) ?>
                    </option>
                <?php endforeach; ?>
            </select>
      
<button type="submit">Find Destinations</button>

            <a href="Travelplanner.php">Clear Filters</a>

        </form>
    </section>


<section class="Destinations-list">
        <h2>Explore Destinations</h2>

        <p>
            <?= count($destinations) ?>
            destination(s) found.
        </p>

        <div class="destination-results">

            <?php if (empty($destinations)): // if no destination found then its a empty array ?>

                <p class="no-results">
                    No destinations found.
                    Try another search or category.
                </p>
    <?php else: ?>

                <?php foreach ($destinations as $destination): ?>
                <article class="destination-card">   <!-- Outer Container or layout -->

    <div class="destination-content">

        <span class="category-label"> <!-- Small inline created for categories -->
            <?= escapeHTML($destination['category']) ?>
        </span>

     <h3>  <!--Paragrapgh created containing Destinaiton's info -->
                                <?= escapeHTML($destination['name']) ?>,
                                <?= escapeHTML($destination['country']) ?>
                            </h3>

                            <p class="destination-description">
                                <?= escapeHTML($destination['description']) ?>
                            </p>

                            <p>
                                <strong>Estimated daily cost:</strong>
                                $<?= number_format(
                                    (float) $destination['avg_daily_cost'],
                                    2
                                ) ?>
                            </p>

    </div>
</article>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </section>

<?php require_once 'footer.inc'; ?>


</main>



</body>
</html> 
 
