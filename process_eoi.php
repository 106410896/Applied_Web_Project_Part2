<?php 

/* blocks direct url access and kicks back to apply.php if attempted */
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['job-ref-num'])) {
    header("Location: apply.php");
    exit();
}

/* include database settings */
require_once('settings.php');

/* automatically creates eoi table if not in database */
$create_table_query = "CREATE TABLE IF NOT EXISTS eoi (
    eoi_id INT AUTO_INCREMENT PRIMARY KEY,
    job_ref_num CHAR(6) NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    street_address VARCHAR(40) NOT NULL,
    suburb_town VARCHAR(40) NOT NULL,
    state ENUM('VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT') NOT NULL,
    postcode CHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(12) NOT NULL,
    skill_html INT(1) DEFAULT 0 NOT NULL,
    skill_css INT(1) DEFAULT 0 NOT NULL,
    skill_javascript INT(1) DEFAULT 0 NOT NULL,
    skill_php INT(1) DEFAULT 0 NOT NULL,
    skill_mysql INT(1) DEFAULT 0 NOT NULL,
    other_skills TEXT NULL,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New' NOT NULL
)";
mysqli_query($conn, $create_table_query);

/* 
________________________________________________________________________________________________________________________

PROCESSING AND SANTISATION
________________________________________________________________________________________________________________________

*/

/* the clean_input helper function sanitises input data and returns it */
function clean_input($data, $conn) {
    $data = trim($data);
    $data = stripslashes($data);
    return mysqli_real_escape_string($conn, $data);
}

/* mapping of fields to reduce redundancy */
$field_map = [
    'job_ref'    => 'job-ref-num',
    'first_name' => 'first-name',
    'last_name'  => 'last-name',
    'dob'        => 'DOB',
    'gender'     => 'gender',
    'street'     => 'street-address',
    'suburb'     => 'suburb-town',
    'state'      => 'state',
    'postcode'   => 'postcode',
    'email'      => 'email',
    'phone'      => 'phone-number',
    'other_txt'  => 'other-skills'
];

$form_data = [];

/* dynamically executes clean_input helper function 
 with null coalescing in place */
foreach ($field_map as $clean_key => $post_key) {
    $form_data[$clean_key] = clean_input($_POST[$post_key] ?? '', $conn);
}

/* ensures even if nothing was ticked in skills field or it doesn't exist,
 code safely defaults to harmless empty array instead of throwing an error */
$skills_array = isset($_POST['skills']) && is_array($_POST['skills']) ? $_POST['skills'] : [];

/* builds expected list and creates an empty dictionary to be dynamically filled */
$target_skills = ['HTML', 'CSS', 'JavaScript', 'PHP', 'MySQL'];
$skills = [];

/* dynamically checks exactly what checkboxes have been ticked and not ticked */
foreach ($target_skills as $skill) {
    $skills[$skill] = in_array($skill, $skills_array) ? 1 : 0;
}

/*
________________________________________________________________________________________________________________________

VALIDATION
________________________________________________________________________________________________________________________

*/

/* initialised an empty error bucket for accumulation of validation errors*/
$errors = [];

// Job Ref Num validation (Must be exactly 6 digits)
if (empty($form_data['job_ref']) || !preg_match("/^[0-9]{6}$/", $form_data['job_ref'])) {
    $errors[] = "Job Reference Number must be exactly 6 digits.";
}

// First Name validation (Letters and spaces only, max 20 characters)
if (empty($form_data['first_name']) || !preg_match("/^[A-Za-z\s]{1, 20}$/", $form_data['first_name'])) {
    $errors[] = "First name must contain only alphabetical letters and be 1-20 characters long.";
}

// Last Name validation (Letters and spaces only, max 20 characters)
if (empty($form_data['last_name']) || !preg_match("/^[A-Za-z\s]{1, 20}$/", $form_data['last_name'])) {
    $errors[] = "Last name must contain only alphabetical letters and be 1-20 characters long.";
}

// Date of Birth validation (Must be a valid date format)
if (empty($form_data['dob']) || !strtotime($form_data['dob'])) {
    $errors[] = "Please provide a valid Date of Birth.";
}

// Gender validation (Must strictly match radio button values)
if (empty($form_data['gender']) || !in_array($form_data['gender'], ['Male', 'Female'])) {
    $errors[] = "Please select one of the options from the list.";
}

// Street Address validation (Required string, max 40 characters)
if (empty($form_data['street']) || !preg_match($form_data['street']) > 40) {
    $errors[] = "Street Address is required and cannot exceed 40 characters long.";
}

// Suburb validation (Required string, max 40 characters)
if (empty($form_data['suburb']) || !preg_match($form_data['suburb']) > 40) {
    $errors[] = "Suburb is required and cannot exceed 40 characters long.";
}

// States validation (Must match a real Australian state)
if (empty($form_data['state']) || !preg_match($form_data['state']) > 40) {
    $errors[] = "Please pick a valid Australian state from the list.";
}

// Postcode validation (Must be exactly 4 digits)
if (empty($form_data['postcode']) || !preg_match("/^[0-9]{4}$/", $form_data['postcode'])) {
    $errors[] = "Postcode must contain exactly 4 digits.";
}

// Email validation (Must be a valid email)
if (empty($form_data['email']) || !filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email.";
}

// Email validation (Must be a valid email)
if (empty($form_data['phone']) || !preg_match("/^[0-9]{8, 12}$/", $form_data['phone'])) {
    $errors[] = "Phone number must contain between 8 to 12 digits.";
}