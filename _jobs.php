<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Job Title Page">
  <meta name="keywords" content="">
  <meta name="author" content="Ollie Madu">

  <link rel="stylesheet" href="styles/jobs.css">
  <link rel="stylesheet" href="styles/styles.css">

  <title>Position Description Page</title>
</head>
<body>
    <?php include 'nav.inc';

    require_once('_settings.php');
    $db_con = mysqli_connect("localhost", "root", "", "fantastic5");

    $sql = "SELECT * FROM jobs_table";
    $result = mysqli_query($db_con, $sql); ?>

        <?php if ($result) 
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    echo "<section class='column'>";
                        echo "<h1>".$row['title']."</h1>";
                        echo "<h2 style='text-align: right;'><strong>Ref No. </strong>F01X2</h2>";
                        
                        echo "<ul class='auto-view'>";
                            echo "<li>".$row['schedule']."</li>";
                        echo "</ul>";

                    echo "<p style='margin-block: 70px;'></p>";

                    // Set to be hidden unless mouse hovers the column

                    echo "<div class='toggle-view'>";
                        echo "<h2>Description:</h2>";
                        echo "<p><strong>".$row['description']."</strong></p>";

                       echo "<h2>Key Responsibilities Include:</h2>";
                        echo "<ol>";
                        echo "<li>".$row['responsibilities']."</li>";
                        echo "<ol>";

                        echo "<h2>Key Skills:</h2>";
                        echo "<ul>";
                        echo "<li>".$row['key_skills']."</li>";
                        echo "</ul>";

                        echo "<h2>Preferable Skills:</h2>";
                        echo "<ul>";
                        echo "<li>".$row['preferable_skills']."</li>";
                        echo "</ul>";


                        echo "<p style='margin-block: 40px; line-height: 150px;'></p>";

                        // Reporting Line
                        echo "<p><em>".$row['contact']."</em><a href='mailto:106510262@student.swin.edu.au' target='_blank'
                        title='Reporting Line'>Email</a></p>";

                        echo "<p style='margin-block: 40px; line-height: 150px;'></p>";

                        // Apply button
                        echo "<a href='apply.php' class='button'>Apply</a>";
                    echo "</div>";
                    echo "</section>";
                }  
            }?>      

</body>