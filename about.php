<!-- use http://localhost/Applied_Web_Project_Part2/index.php to debug -->

<?php

/* variables declared for dynamic page author, title setting and stylesheet loading */
    $page_author = "Isaac";
    $page_title = "About Fantastic 5";
    $page_description = "Applied Web Project - About page (Fantastic5)";

    $page_stylesheets = [
        "styles/about.css"
    ];

/* include file 'header.inc' used for header to avoid repetition */
    include 'header.inc';
    require_once 'settings.php';
    
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    $sql = "SELECT * FROM team_members ORDER BY member_id";
    $result = mysqli_query($conn, $sql);

?>

<body>

  <style>
    #group-information {
      padding-left: 15px;
      border-left: 10px solid #17365d;
    }
  </style>

   <!-- include file 'nav.inc' used for navigation bar to avoid repetition -->
    <?php include 'nav.inc'; ?>

  <main>
    <h1>About Fantastic 5</h1>
    <section id="group-information">
      <h2>Group Information</h2>

     
      <ul>
        <li>
          Group name
          <ul>
            <li>Fantastic 5</li>
          </ul>
        </li>

        <li>
          Tutorial class
          <ul>
            <li>Tuesday</li>
            <li>12:30 pm–2:30 pm</li>
          </ul>
        </li>
      </ul>
    </section>

    <section id="group-photo">
      <h2>Our Team</h2>

      <figure>
        <img
          src="images/team.jpeg" id="team-photo" alt="Fantastic 5 Team Photo">

           <figcaption style="font-weight: bold;">
              Fantastic 5 team members at Swinburne University.
          </figcaption>

      </figure>
    </section>

    <section id="contributions">
    <h2>Member Contributions</h2>

    <dl>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<dt>" . htmlspecialchars($row['member_name']) . "</dt>";
            echo "<dd>" . htmlspecialchars($row['contribution']) . "</dd>";
        }
        ?>
    </dl>
</section>

    <section id="fun-facts">
      <h2>Team Fun Facts</h2>

      <table>
        <caption>Fun Facts About the Fantastic 5 Members</caption>

        <thead>
          <tr>
            <th scope="col">Team Member</th>
            <th scope="col">Student ID</th>
            <th scope="col">Fun Fact</th>
            <th scope="col">Project Role</th>
            
          </tr>
        </thead>

          <tbody>
              <?php
              // Run the query again for the second display.
              $result = mysqli_query($conn, $sql);

              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<th scope='row'>" . htmlspecialchars($row['member_name']) . "</th>";
                  echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['fun_fact']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['project_role']) . "</td>";
                  echo "</tr>";
              }

              mysqli_close($conn);
              ?>
          </tbody>
      </table>
    </section>

  </main>

  <!-- include file 'footer.inc' used for footer to avoid repetition -->
    <?php include 'footer.inc'; ?>

</body>
</html>