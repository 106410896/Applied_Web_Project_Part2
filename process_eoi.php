<?php 

/* blocks direct url access and kicks back to apply.php if attempted */
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['job-ref-num'])) {
    header("Location: apply.php")
    exit();
}

/* include database settings */
require_once('settings.php');

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