
<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "fantastic5");

if (!$conn) {
    die("Database connection failed");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = mysqli_prepare($conn,
        "SELECT user_id, password FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $hash);

    if (mysqli_stmt_fetch($stmt) && password_verify($password, $hash)) {
        session_regenerate_id(true);
        $_SESSION["hr_logged_in"] = true;
        $_SESSION["hr_user_id"] = $user_id;
        mysqli_stmt_close($stmt);
        header("Location:manage.php");
        exit();
    }

    mysqli_stmt_close($stmt);
    $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Login</title>
</head>
<body>

<h1>HR Management Login</h1>

<p><?php echo htmlspecialchars($error); ?></p>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>

    <br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
