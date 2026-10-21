<!-- use http://localhost/Applied_Web_Project_Part2/index.php to debug -->

<?php

/* variables declared for dynamic page author, title setting and stylesheet loading */
    $page_author = "Ollie Madu";
    $page_title = "Position Description Page";
    $page_description = "Applied Web Project - Jobs page (Fantastic5)";

    $page_stylesheets = ["styles/jobs.css"];

/* include file 'header.inc' used for header to avoid repetition */
    include 'header.inc';

?>

<body>
    <?php include 'nav.inc';

    require_once('settings.php');

    $sql = "SELECT * FROM jobs_table";
    $result = mysqli_query($conn, $sql); ?>

    <p style="margin-block: 60px;"></p>
    <h1 style="text-align: center; color: rgb(18, 18, 91);">Open Positions</h1>
    <p style="margin-block: 60px;"></p>

    <aside>
    <h3> Currently Open Positions</h3>
    <form action="job_result.php" method="get">
        <label for="job"><strong>Enter Job Name: </strong></label>
        <input type="text" id="job" name="job" required>
    </form>
    <p>*Hover over each listing to see more details regarding the relevant position.</p>
  </aside>

    <div>

        <?php if ($result) 
            {
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
                        title='Reporting Line'>(Email)</a></p>";

                        echo "<p style='margin-block: 40px; line-height: 150px;'></p>";

                        // Apply button
                        echo "<a href='apply.php' class='button'>Apply</a>";
                    echo "</div>";
                    echo "</section>";
                }  
            }?>   
            
    </div>

</body>