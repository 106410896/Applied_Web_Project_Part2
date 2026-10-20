
<?php
session_start();

if (!isset($_SESSION['hr_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'settings.php';

function clean($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['token']) ||
        !hash_equals($_SESSION['token'], $_POST['token'])) {
        exit("Invalid request");
    }

    if ($_POST['action'] == 'update') {

        $number = filter_var(
            $_POST['number'],
            FILTER_VALIDATE_INT
        );

        $status = $_POST['status'];

        if ($number !== false &&
            $number > 0 &&
            in_array($status, ['New', 'Current', 'Final'], true)) {

            $stmt = $conn->prepare(
                "UPDATE eoi SET status = ? WHERE EOInumber = ?"
            );

            $stmt->bind_param("si", $status, $number);
            $stmt->execute();
            $stmt->close();

            $message = "Status updated successfully";
        }
    }

    if ($_POST['action'] == 'delete') {

        $reference = trim($_POST['delete_ref'] ?? '');

        if ($reference != '' &&
            ($_POST['confirm'] ?? '') == 'yes') {

            $stmt = $conn->prepare(
                "DELETE FROM eoi WHERE job_ref = ?"
            );

            $stmt->bind_param("s", $reference);
            $stmt->execute();

            $message = $stmt->affected_rows .
                " applications deleted";

            $stmt->close();
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

$sql = "SELECT * FROM eoi WHERE 1=1";

$values = [];
$types = "";

if ($job != '') {
    $sql .= " AND job_ref = ?";
    $values[] = $job;
    $types .= "s";
}

if ($first != '') {
    $sql .= " AND first_name LIKE ?";
    $values[] = "%" . $first . "%";
    $types .= "s";
}

if ($last != '') {
    $sql .= " AND last_name LIKE ?";
    $values[] = "%" . $last . "%";
    $types .= "s";
}

$sql .= " ORDER BY $sort";

$stmt = $conn->prepare($sql);

if (count($values) > 0) {
    $stmt->bind_param($types, ...$values);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HR Management</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

<?php include 'header.inc'; ?>
<?php include 'nav.inc'; ?>

<h1>Tourism and Travel Technology Platform</h1>
<h2>HR Management</h2>

<p><a href="logout.php">Logout</a></p>

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

    <?php while ($row = $result->fetch_assoc()) { ?>

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

<?php
$stmt->close();
$conn->close();
?>

