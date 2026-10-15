<?php
require_once 'settings.php'; //connect to settings php and database 

require_once 'Travelplanner_functions.inc';  //load the funcitons used by travel planner

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');  // Get Search and Category values from the URL

$allowedCategories = 