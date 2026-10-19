<!DOCTYPE html>
<html lang="en">
<head>
    <title> Filtered Jobs Page</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML5">
    <meta name="author" content="">

    <link rel="stylesheet" href="styles/jobs.css">
    <link rel="stylesheet" href="styles/styles.css">

</head>

<body>
    <?php 
        require_once('_settings.php');
        $db_con = mysqli_connect("localhost", "root", "", "fantastic5");

        $job_entered = mysqli_real_escape_string($db_con, $_GET['job']);

        if (isset($job_entered))
        {
            $sql = "SELECT * FROM jobs_table WHERE title like '%$job_entered%'";
            $result = mysqli_query($db_con, $sql);

            if (mysqli_num_rows($result) > 0) 
            {
                echo "<h1>Results: </h1>";
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    echo "<section class='column'>";
                        echo "<h1>".$row['title']."</h1>";
                        echo "<h2 style='text-align: right;'><strong>Ref No. </strong>".$row['ref_num']."</h2>";

                    echo "<ul class='auto-view'>";
                        echo "<li>".$row['work_type']."</li>";
                        echo "<li>".$row['location']."</li>";
                        echo "<li>".$row['salary']."</li>";
                    echo "</ul>";

                    echo "<p style='margin-block: 70px;'></p>";

                    // Set to be hidden unless mouse hovers the column

                    echo "<div class='toggle-view'>";
                        echo "<h2>Description:</h2>";
                        echo "<p>".$row['description']."</p>";

                       echo "<h2>Key Responsibilities Include:</h2>";
                        echo "<ol>";
                            echo "<li>".$row['kr_1']."</li>";
                            echo "<li>".$row['kr_2']."</li>";
                            echo "<li>".$row['kr_3']."</li>";
                            echo "<li>".$row['kr_4']."</li>";
                            echo "<li>".$row['kr_5']."</li>";
                        echo "</ol>";

                        echo "<h2>Key Skills:</h2>";
                        echo "<ul>";
                            echo "<li>".$row['ks_1']."</li>";
                            echo "<li>".$row['ks_2']."</li>";
                            echo "<li>".$row['ks_3']."</li>";
                            echo "<li>".$row['ks_4']."</li>";
                            echo "<li>".$row['ks_5']."</li>";
                        echo "</ul>";

                        echo "<h2>Preferable Skills:</h2>";
                        echo "<ul>";
                        echo "<li>".$row['preferable_skills']."</li>";
                        echo "</ul>";


                        echo "<p style='margin-block: 40px; line-height: 150px;'></p>";

                        // Reporting Line
                        echo "<p><em>".$row['contact']."</em><a href=".$row['email']." target='_blank'
                        title='Reporting Line'> (Email)</a></p>";

                        echo "<p style='margin-block: 40px; line-height: 150px;'></p>";

                        // Apply button
                        echo "<a href='apply.php' class='button'>Apply</a>";
                    echo "</div>";
                    echo "</section>";
                }
            }
            else
            {
                echo "🚫 No matching jobs found. <a href='_jobs.php'>Try Again</a>";
            }
            mysqli_close($db_con);
        }
        else
        {
            echo "Invalid login. <a href='_jobs.php'>Please enter a job to search.</a>";
        }

    ?>
</body>