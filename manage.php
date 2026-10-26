
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Protect HR Management page
if (empty($_SESSION['hr_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Connect to MySQL database
 require_once('settings.php');

// Function to safely display text
function clean($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Create security token
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$message = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check security token
    if (!isset($_POST['token']) ||
        !hash_equals($_SESSION['token'], $_POST['token'])) {
        exit("Invalid request");
    }

    $action = $_POST['action'] ?? '';

    // Update application status
    if ($action == 'update') {

        $number = filter_var(
            $_POST['number'] ?? null,
            FILTER_VALIDATE_INT
        );

        $status = $_POST['status'] ?? '';

        if ($number !== false &&
            $number > 0 &&
            in_array($status, ['New', 'Current', 'Final'], true)) {

            $stmt = mysqli_prepare(
                $conn,
                "UPDATE eoi SET status = ? WHERE EOInumber = ?"
            );

            mysqli_stmt_bind_param($stmt, "si", $status, $number);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Status updated successfully";
            } else {
                $message = "Could not update status";
            }

            mysqli_stmt_close($stmt);

        } else {
            $message = "Invalid application number or status";
        }
    }

    // Delete applications by job reference
    if ($action == 'delete') {

        $reference = trim($_POST['delete_ref'] ?? '');
        $confirm = $_POST['confirm'] ?? '';

        if ($reference != '' && $confirm == 'yes') {

            $stmt = mysqli_prepare(
                $conn,
                "DELETE FROM eoi WHERE job_ref = ?"
            );

            mysqli_stmt_bind_param($stmt, "s", $reference);

            if (mysqli_stmt_execute($stmt)) {
                $deleted = mysqli_stmt_affected_rows($stmt);
                $message = $deleted . " applications deleted";
            } else {
                $message = "Could not delete applications";
            }

            mysqli_stmt_close($stmt);

        } else {
            $message = "Please confirm deletion";
        }
    }
}

// Get search values
$job = trim($_GET['job'] ?? '');
$first = trim($_GET['first'] ?? '');
$last = trim($_GET['last'] ?? '');
$sort = $_GET['sort'] ?? 'EOInumber';

// Allowed sorting fields
$allowed = [
    'EOInumber',
    'job_ref',
    'first_name',
    'last_name',
    'status'
];

if (!in_array($sort, $allowed, true)) {
    $sort = 'EOInumber';
}

// Search applications in database
$sql = "SELECT * FROM eoi
        WHERE job_ref LIKE ?
        AND first_name LIKE ?
        AND last_name LIKE ?
        ORDER BY `$sort` ASC";

$jobSearch = $job == '' ? '%' : $job;
$firstSearch = '%' . $first . '%';
$lastSearch = '%' . $last . '%';

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $jobSearch,
    $firstSearch,
    $lastSearch
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>

<main>

<h1>Tourism and Travel Technology Platform</h1>
<h2>HR Management</h2>

<p><?php echo clean($message); ?></p>

<p>
    <a href="logout.php">Logout</a>
</p>

<h2>Search Job Applications</h2>

<form method="get" action="manage.php">

    <p>
        <label for="job">Job Reference:</label>
        <input type="text" name="job" id="job"
               value="<?php echo clean($job); ?>">
    </p>

    <p>
        <label for="first">First Name:</label>
        <input type="text" name="first" id="first"
               value="<?php echo clean($first); ?>">
    </p>

    <p>
        <label for="last">Last Name:</label>
        <input type="text" name="last" id="last"
               value="<?php echo clean($last); ?>">
    </p>

    <p>
        <label for="sort">Sort By:</label>

        <select name="sort" id="sort">

            <?php foreach ($allowed as $field) { ?>

                <option value="<?php echo clean($field); ?>"
                    <?php if ($sort == $field) echo 'selected'; ?>>

                    <?php echo clean($field); ?>

                </option>

            <?php } ?>

        </select>
    </p>

    <p>
        <input type="submit" value="Search">
        <a href="manage.php">Show All</a>
    </p>

</form>

<h2>All Job Applications</h2>

<table border="1">

    <tr>
        <th>EOI Number</th>
        <th>Job Reference</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Update</th>
    </tr>

    <?php foreach ($applications as $row) { ?>

    <tr>
        <td><?php echo clean($row['EOInumber']); ?></td>
        <td><?php echo clean($row['job_ref']); ?></td>
        <td><?php echo clean($row['first_name']); ?></td>
        <td><?php echo clean($row['last_name']); ?></td>
        <td><?php echo clean($row['email']); ?></td>
        <td><?php echo clean($row['status']); ?></td>

        <td>
            <form method="post" action="manage.php">

                <input type="hidden" name="token"
                       value="<?php echo clean($_SESSION['token']); ?>">

                <input type="hidden" name="action" value="update">

                <input type="hidden" name="number"
                       value="<?php echo clean($row['EOInumber']); ?>">

                <select name="status">

                    <option value="New"
                        <?php if ($row['status'] == 'New') echo 'selected'; ?>>
                        New
                    </option>

                    <option value="Current"
                        <?php if ($row['status'] == 'Current') echo 'selected'; ?>>
                        Current
                    </option>

                    <option value="Final"
                        <?php if ($row['status'] == 'Final') echo 'selected'; ?>>
                        Final
                    </option>

                </select>

                <input type="submit" value="Update">

            </form>
        </td>
    </tr>

    <?php } ?>

</table>

<?php if (count($applications) == 0) { ?>
    <p>No applications found.</p>
<?php } ?>

<h2>Delete Applications</h2>

<form method="post" action="manage.php">

    <input type="hidden" name="token"
           value="<?php echo clean($_SESSION['token']); ?>">

    <input type="hidden" name="action" value="delete">

    <p>
        <label for="delete_ref">Job Reference:</label>

        <input type="text" name="delete_ref"
               id="delete_ref" required>
    </p>

    <p>
        <input type="checkbox" name="confirm"
               value="yes" id="confirm" required>

        <label for="confirm">
            Confirm deletion of all applications for this job
        </label>
    </p>

    <p>
        <input type="submit" value="Delete Applications">
    </p>

</form>

</main>

<?php include 'footer.inc'; ?>

</body>
</html>


