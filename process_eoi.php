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
if (empty($form_data['first_name']) || !preg_match("/^[A-Za-z\s]{1,20}$/", $form_data['first_name'])) {
    $errors[] = "First name must contain only alphabetical letters and be 1-20 characters long.";
}

// Last Name validation (Letters and spaces only, max 20 characters)
if (empty($form_data['last_name']) || !preg_match("/^[A-Za-z\s]{1,20}$/", $form_data['last_name'])) {
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
if (empty($form_data['street']) || !strlen($form_data['street']) > 40) {
    $errors[] = "Street Address is required and cannot exceed 40 characters long.";
}

// Suburb validation (Required string, max 40 characters)
if (empty($form_data['suburb']) || !strlen($form_data['suburb']) > 40) {
    $errors[] = "Suburb is required and cannot exceed 40 characters long.";
}

// States validation (Must match a real Australian state)
if (empty($form_data['state']) || !in_array($form_data['state'])) {
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

/*
________________________________________________________________________________________________________________________

DATABASE INSERTION & FRONT-END PRESENTATION
________________________________________________________________________________________________________________________

*/

if (count($errors) > 0) {
    // if any submission fails server validation loops, 
    // this message is displayed along with specific errors shown
    echo "<h1>Application Submission Failed</h1>";
    echo "<p>Please correct the following errors before re-submitting:</p>";
    echo "<ul style='color: red;'>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";

    // link to allow user to return to apply page
    echo "<p><a href='apply.php'>Click here to return to the application page</a></p>";
} else {
    $insert_query = "INSERT INTO eoi (
            job_ref_num, first_name, last_name, dob, gender, street_address, 
            suburb_town, state, postcode, email, phone_number, 
            skill_html, skill_css, skill_javascript, skill_php, skill_mysql, other_skills
        ) VALUES (
            '{$form_data['job_ref']}', '{$form_data['first_name']}', '{$form_data['last_name']}', 
            '{$form_data['dob']}', '{$form_data['gender']}', '{$form_data['street']}', 
            '{$form_data['suburb']}', '{$form_data['state']}', '{$form_data['postcode']}', 
            '{$form_data['email']}', '{$form_data['phone']}', 
            '{$skills['HTML']}', '{$skills['CSS']}', '{$skills['JavaScript']}', 
            '{$skills['PHP']}', '{$skills['MySQL']}', '{$form_data['other_txt']}'
        )";

        $execute_save = mysqli_query($conn, $insert_query);

        if ($execute_save) {
            // fetch auto-generated unique EOInumber
            $EOInumber = mysqli_insert_id($conn);

            echo "<div style='max-width: 600px; margin: 20px auto; padding: 20px; border: 2px solid #4CAF50; font-family: sans-serif;'>";
            echo "<h1 style='color: #4CAF50;'>Application Successfully Submitted!</h1>";
            echo "<p>Thank you for submitting your interest, <strong>" . htmlspecialchars($_POST['first-name'] ?? '') . "</strong>.</p>";
            echo "<p style='font-size: 1.2em;'>Your Application Number is: <strong>" . $EOInumber . "</strong></p>";
            echo "<p><a href='index.php'>Return back to Home Page</a></p>";
            echo "</div>";
        } else {
            echo "<p>System error: Unable to submit your application." . mysqli_error($conn) . "</p>";
        }

}

/* closes connection */
mysqli_close($conn);

?>