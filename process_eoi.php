<?php 

/* blocks direct url access and kicks back to apply.php if attempted */
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['job-ref-num'])) {
    header("Location: apply.php")
    exit();
}

/* include database settings */
require_once('settings.php');

