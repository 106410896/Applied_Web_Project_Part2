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
    <?php 
    include 'nav.inc';

        //Connects to our database.
        require_once('settings.php');
        $db_con = mysqli_connect("localhost", "root", "", "fantastic5");

        if ($db_con)
        {
            //Creates a query that only selects models from our car table if they match the user's input.
            $sql = "SELECT * FROM jobs_table";
            $result = mysqli_query($db_con, $sql);

            if (mysqli_num_rows($result) > 0) 
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    // echo "<tr>";
                    // echo "<td>" . $row['title'] . "</td>";
                    // echo "<td>" . $row['schedule'] . "</td>";
                    // echo "<td>" . $row['description'] . "</td>";
                    // echo "<td>" . $row['responsibilities'] . "</td>";
                    // echo "<td>" . $row['key_skills'] . "</td>";
                    // echo "<td>" . $row['preferable_skills'] . "</td>";
                    // echo "<td>" . $row['contact'] . "</td>";
                    // echo "</tr>";
                    echo <<<EOL
                    <section class="column">
                    <h1> . $row['title'] . </h1>
                    <h2 style="text-align: right;"><strong>Ref No. </strong>F01X2</h2>

                    <ul class="auto-view">
                        <li>$row['schedule']</li>
                    </ul>

                    <p style="margin-block: 70px;"></p>

                    <div class="toggle-view">
                        <h2>Description:</h2>
                        <p> $row['description']</p>

                        <h2>Key Responsibilities Include:</h2>
                        <ol>
                        <li>$row['responsibilities']</li>
                        </ol>

                        <h2>Key Skills:</h2>
                        <ul>
                        <li>$row['key_skills']</li>
                        </ul>

                        <h2>Preferable Skills:</h2>
                        <ul>
                        <li>$row['preferable_skills']</li>
                        </ul>

                        <p style="margin-block: 40px; line-height: 150px;"></p>

                        <p>
                        <em>$row['contact']</em> 
                        <a href="mailto:106510262@student.swin.edu.au" target="_blank" 
                        title="Reporting Line">Email</a>
                        </p>

                        <p style="margin-block: 40px; line-height: 150px;"></p>

                        <a href="apply.php" class="button">Apply</a>
                    </div>

                        </section>
                    EOL;
                }
            }
            else
            {
                echo "🚫 No listings. ";
            }
            mysqli_close($db_con);
        }
        else
        {
            echo "Invalid login.";
        }

    ?>
</body>