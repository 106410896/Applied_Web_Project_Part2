
<?php
session_start();

function clean($x) {
    return htmlspecialchars((string)$x, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['applications'])) {
    $_SESSION['applications'] = [
        ['id'=>1, 'job'=>'JOB001', 'first'=>'John', 'last'=>'Smith', 'email'=>'john@example.com', 'status'=>'New'],
        ['id'=>2, 'job'=>'JOB002', 'first'=>'Sarah', 'last'=>'Wilson', 'email'=>'sarah@example.com', 'status'=>'Current'],
        ['id'=>3, 'job'=>'JOB001', 'first'=>'David', 'last'=>'Brown', 'email'=>'david@example.com', 'status'=>'Final']
    ];
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!hash_equals($_SESSION['token'], $_POST['token'] ?? '')) {
        exit('Invalid request');
    }

    if (($_POST['action'] ?? '') == 'update') {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $status = $_POST['status'] ?? '';

        if ($id !== false && in_array($status, ['New', 'Current', 'Final'], true)) {
            foreach ($_SESSION['applications'] as &$app) {
                if ($app['id'] == $id) {
                    $app['status'] = $status;
                    $message = 'Status updated';
                    break;
                }
            }
            unset($app);
        }
    }

    if (($_POST['action'] ?? '') == 'delete' && ($_POST['confirm'] ?? '') == 'yes') {
        $ref = trim($_POST['ref'] ?? '');
        if ($ref !== '') {
            $_SESSION['applications'] = array_values(array_filter(
                $_SESSION['applications'],
                fn($a) => $a['job'] !== $ref
            ));
            $message = 'Applications deleted';
        }
    }
}

$job = trim($_GET['job'] ?? '');
$first = trim($_GET['first'] ?? '');
$last = trim($_GET['last'] ?? '');
$sort = $_GET['sort'] ?? 'id';

$fields = ['id', 'job', 'first', 'last', 'status'];
if (!in_array($sort, $fields, true)) $sort = 'id';

$apps = array_values(array_filter(
    $_SESSION['applications'],
    fn($a) =>
        ($job == '' || $a['job'] == $job) &&
        ($first == '' || stripos($a['first'], $first) !== false) &&
        ($last == '' || stripos($a['last'], $last) !== false)
));

usort($apps, fn($a, $b) => $a[$sort] <=> $b[$sort]);
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

<p><?= clean($message) ?></p>

<h2>Search Applications</h2>

<form method="get">
    <input name="job" placeholder="Job Reference" value="<?= clean($job) ?>">
    <input name="first" placeholder="First Name" value="<?= clean($first) ?>">
    <input name="last" placeholder="Last Name" value="<?= clean($last) ?>">

    <select name="sort">
        <?php foreach ($fields as $field): ?>
            <option value="<?= clean($field) ?>" <?= $sort == $field ? 'selected' : '' ?>>
                <?= clean($field) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Search</button>
    <a href="manage.php">Show All</a>
</form>

<h2>Job Applications</h2>

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

<?php foreach ($apps as $a): ?>
<tr>
    <td><?= clean($a['id']) ?></td>
    <td><?= clean($a['job']) ?></td>
    <td><?= clean($a['first']) ?></td>
    <td><?= clean($a['last']) ?></td>
    <td><?= clean($a['email']) ?></td>
    <td><?= clean($a['status']) ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="token" value="<?= clean($_SESSION['token']) ?>">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= clean($a['id']) ?>">

            <select name="status">
                <?php foreach (['New', 'Current', 'Final'] as $s): ?>
                    <option value="<?= $s ?>" <?= $a['status'] == $s ? 'selected' : '' ?>>
                        <?= $s ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Update</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php if (count($apps) == 0): ?>
    <p>No applications found.</p>
<?php endif; ?>

<h2>Delete Applications</h2>

<form method="post">
    <input type="hidden" name="token" value="<?= clean($_SESSION['token']) ?>">
    <input type="hidden" name="action" value="delete">

    <input name="ref" placeholder="Job Reference" required>

    <label>
        <input type="checkbox" name="confirm" value="yes" required>
        Confirm deletion
    </label>

    <button type="submit">Delete Applications</button>
</form>

<?php include 'footer.inc'; ?>

</body>
</html>

