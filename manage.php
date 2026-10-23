
<?php
session_start();


function clean($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}


if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}


if (!isset($_SESSION['applications'])) {
    $_SESSION['applications'] = [
        [
            'EOInumber' => 1,
            'job_ref' => 'JOB001',
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john@example.com',
            'status' => 'New'
        ],
        [
            'EOInumber' => 2,
            'job_ref' => 'JOB002',
            'first_name' => 'Sarah',
            'last_name' => 'Wilson',
            'email' => 'sarah@example.com',
            'status' => 'Current'
        ],
        [
            'EOInumber' => 3,
            'job_ref' => 'JOB001',
            'first_name' => 'David',
            'last_name' => 'Brown',
            'email' => 'david@example.com',
            'status' => 'Final'
        ]
    ];
}

$message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['token']) ||
        !hash_equals($_SESSION['token'], $_POST['token'])) {
        exit("Invalid request");
    }

    $action = $_POST['action'] ?? '';

    
    if ($action == 'update') {

        $number = filter_var(
            $_POST['number'] ?? null,
            FILTER_VALIDATE_INT
        );

        $status = $_POST['status'] ?? '';

        if ($number !== false &&
            $number > 0 &&
            in_array($status, ['New', 'Current', 'Final'], true)) {

            $updated = false;

            foreach ($_SESSION['applications'] as &$application) {
                if ($application['EOInumber'] == $number) {
                    $application['status'] = $status;
                    $updated = true;
                    break;
                }
            }

            unset($application);

            $message = $updated
                ? "Status updated successfully"
                : "Application not found";
        } else {
            $message = "Invalid application number or status";
        }
    }

    
    if ($action == 'delete') {

        $reference = trim($_POST['delete_ref'] ?? '');
        $confirm = $_POST['confirm'] ?? '';

        if ($reference != '' && $confirm == 'yes') {

            $before = count($_SESSION['applications']);

            $_SESSION['applications'] = array_values(
                array_filter(
                    $_SESSION['applications'],
                    function ($application) use ($reference) {
                        return $application['job_ref'] !== $reference;
                    }
                )
            );

            $deleted = $before - count($_SESSION['applications']);

            $message = $deleted . " applications deleted";

        } else {
            $message = "Please confirm deletion";
        }
    }
}


$job = trim($_GET['job'] ?? '');
$first = trim($_GET['first'] ?? '');
$last = trim($_GET['last'] ?? '');
$sort = $_GET['sort'] ?? 'EOInumber';


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


$applications = $_SESSION['applications'];


$applications = array_values(
    array_filter(
        $applications,
        function ($row) use ($job, $first, $last) {

            return
                ($job == '' || $row['job_ref'] == $job) &&
                ($first == '' ||
                    stripos($row['first_name'], $first) !== false) &&
                ($last == '' ||
                    stripos($row['last_name'], $last) !== false);
        }
    )
);


usort($applications, function ($a, $b) use ($sort) {
    return $a[$sort] <=> $b[$sort];
});
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

<h1>Tourism and Travel Technology Platform</h1>
<h2>HR Management</h2>

<p><?php echo clean($message); ?></p>

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

<?php include 'footer.inc'; ?>

</body>
</html>


