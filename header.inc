<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Cybershield Website'; ?>">
        <meta name="keywords" content="HTML, COS10026, Project, Fantastic5">

        <meta name="author" content="<?php echo isset($page_author) ? $page_author : 'Team Fantastic5'; ?>">

        <title><?php echo isset($page_title) ? $page_title : 'Applied Web Project'; ?></title>

        <link rel="stylesheet" href="styles/styles.css">

        <?php if (isset($page_stylesheets)) {
            foreach ($page_stylesheets as $sheet) {
                echo '    <link rel="stylesheet" href="' . htmlspecialchars($sheet) . '">' . "\n";
            }
        }
        ?>

        <!-- Embedded CSS example -->
        <style>
            main h1 {
                text-align: center;
                margin-top: 40px;
                margin-bottom: 40px;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            }
        </style>

    </head>