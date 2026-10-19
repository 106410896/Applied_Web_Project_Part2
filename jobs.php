<!-- use http://localhost/Applied_Web_Project_Part2/index.php to debug -->

<?php

/* variables declared for dynamic page author, title setting and stylesheet loading */
    $page_author = "Ollie Madu";
    $page_title = "Position Description Page";
    $page_description = "Applied Web Project - Jobs page (Fantastic5)";

    $page_stylesheets = [
        "styles/jobs.css"
    ];

/* include file 'header.inc' used for header to avoid repetition */
    include 'header.inc';

?>

<!-- Font size, color and style for paragraphs within the aside section -->
  <style>

    aside p {font-size: small; font-style: italic; color: rgb(68, 66, 66);}

  </style>

<body>

<?php include 'nav.inc';?>

  <p style="margin-block: 60px;"></p>
  <h1 style="text-align: center; color: rgb(18, 18, 91);">Open Positions</h1>
  <p style="margin-block: 60px;"></p>

  <!-- List of available jobs -->
  <aside>
    <h3> Currently Open Positions</h3>
    <ul>
      <li><em>Back-End Web Developer</em></li>
      <li><em>Front-End Web Developer</em></li>
      <li><em>Full-Stack Web Developer</em></li>
    </ul>
    <p>*Hover over each listing to see more details regarding the relevant position.</p>
  </aside>

    <div>



<!-- Back-End Description -->
      <section class="column">
      <h1>Back-End Web Developer</h1>
      <h2 style="text-align: right;"><strong>Ref No. </strong>F01X2</h2>

      <ul class="auto-view">
        <li>Full-Time</li>
        <li>On-Location/Remote</li>
        <li>$80K-85K per year</li>
      </ul>

      <p style="margin-block: 70px;"></p>

      <!-- Set to be hidden unless mouse hovers the column -->
      <div class="toggle-view">
        <h2>Description:</h2>
        <p> A Back-End Web Developer To provide code for the structure of an online tourism platform that allows users to access destination information, tour bookings, accommodation services as well as options for a personalised travel plan.
        </p>

        <h2>Key Responsibilities Include:</h2>
        <ol>
          <li>Developing the structure for a responsive tourism website using HTML5.</li>
          <li>Incorparating interactive elements to enchance UX. </li>
          <li>Working closely with your team to reach deadlines.</li>
          <li>Performing Quality Assurance (QA).</li>
          <li>Educating junior programmers.</li>
        </ol>

        <h2>Key Skills:</h2>
        <ul>
          <li>4 years of experience in HTML (including CSS), PHP, MySQL & JavaScript.</li>
          <li>Team managment skills.</li>
          <li>Strong Communication Skills</li>
          <li>Undergraduate Degree in Computer Science.</li>
          <li>Familiarity with relevant APIs</li>
          <li>A positive mindset.</li>
        </ul>

        <h2>Preferable Skills:</h2>
        <ul>
          <li>Fluency in Ruby and Java.</li>
          <li>Some knowledge regarding Front-End Web Development.</li>
        </ul>

        <p style="margin-block: 40px; line-height: 150px;"></p>

        <!-- Reporting Line -->
        <p>
          <em>For further enquiries, please contact here (Ollie Madu):</em> 
          <a href="mailto:106510262@student.swin.edu.au" target="_blank" 
           title="Reporting Line">Email</a>
        </p>

        <p style="margin-block: 40px; line-height: 150px;"></p>

        <!-- Apply button -->
        <a href="apply.php" class="button">Apply</a>
      </div>

        </section>

<!-- Front-End Description -->
      <section class="column">
      <h1>Front-End Web Developer</h1>
      <h2 style="text-align: right;"><strong>Ref No. </strong>B0AZF2</h2>

      <ul class="auto-view">
        <li>Full-Time/Part-Time</li>
        <li>On-Location/Remote</li>
        <li>$110K - 130K per year</li>
      </ul>

      <p style="margin-block: 70px;"></p>

      <!-- Set to be hidden unless mouse hovers the column -->
      <div class="toggle-view">
        <h2>Description:</h2>
        <p> A <strong>Front-End Web Developer</strong> to design a visually appealing cyber-awareness website that incorparates
        a responsive design that can function across all devices.
        </p>

        <h2>Key Responsibilities Include:</h2>
        <ol>
          <li>Design and manage the visual functionality of the website (buttons, scrollbars, etc)</li>
          <li>Keep in touch with back-end developers for clarity or to suggest improvements</li>
          <li>Ensure that the website is well optimised.</li>
          <li>Work closely with your team to reach deadlines.</li>
        </ol>

        <h2>Key Skills:</h2>
        <ul>
          <li>3 years of experience in HTML (including CSS) and JavaScript.</li>
          <li>A Undergraduate Degree in Computer science</li>
          <li>Team managment skills.</li>
          <li>Undergraduate Degree in Computer Science.</li>
          <li>A positive mindset.</li>
        </ul>

        <h2>Preferable Skills:</h2>
        <ul>
          <li>Fluency in SQL, PHP, Ruby and Java</li>
          <li>Knowledge of Back-End web development</li>
          <li>Patience and a wilingness to learn.</li>
        </ul>

        <p style="margin-block: 40px; line-height: 150px;"></p>

        <!-- Reporting Line -->
        <p>
          <em>For further enquiries, please contact here (Shashanth Kumar): </em>
          <a href="mailto:106410896@student.swin.edu.au" target="_blank" 
           title="Reporting Line">Email</a>
        </p>

        <p style="margin-block: 40px; line-height: 150px;"></p>

        <!-- Apply button -->
        <a href="apply.php" class="button">Apply</a>
      </div>

        </section>

<!-- Full-Stack Description -->
      <section class="column">
      <h1>Full-Stack Web Developer</h1>
      <h2 style="text-align: right;"><strong>Ref No. </strong>F01X2</h2>

      <ul class="auto-view">
        <li>Full-Time</li>
        <li>On-Location/Remote</li>
        <li>$80K-85K per year</li>
      </ul>

      <p style="margin-block: 70px;"></p>

      <!-- Set to be hidden unless mouse hovers the column -->
      <div class="toggle-view">
        <h2>Description:</h2>
        <p> A <strong>Full-Stack Web Developer</strong> to handle the Front-End and Back-End development of 
          a cyber-awareness website.
        </p>

        <h2>Key Responsibilities Include:</h2>
        <ol>
          <li>Develop the structure for a responsive cyber-awareness website using HTML5.</li>
          <li>Incorparate interactive elements to enchance UX. </li>
          <li>Work closely with your team to reach deadlines.</li>
          <li>Performing Quality Assurance (QA).</li>
          <li>Educating junior programmers.</li>
        </ol>

        <h2>Key Skills:</h2>
        <ul>
          <li>5 years of experience in HTML (including CSS) and JavaScript.</li>
          <li>Team managment skills.</li>
          <li>Strong Communication Skills</li>
          <li>Undergraduate Degree in Computer Science.</li>
          <li>Knowledge on how to build APIs.</li>
          <li>A positive mindset.</li>
          <li>Experience with cloud computing.</li>
        </ul>

        <h2>Preferable Skills:</h2>
        <ul>
          <li>Fluency in SQL, PHP, Ruby and Java, Node.js, AWS.</li>

        </ul>

        <p style="margin-block: 40px; line-height: 150px;"></p>

        <!-- Reporting Line -->
        <p>
          <em>For further enquiries, please contact here (Issac Malual): </em>
          <a href="mailto:106510262@student.swin.edu.au" target="_blank" 
           title="Reporting Line">Email</a>
        </p>

        <p style="margin-block: 40px; line-height: 150px;"></p>

        <!-- Apply button -->
        <a href="apply.php" class="button">Apply</a>
      </div>

        </section>

    <!-- Footer section -->
    
    </div>
    
</body>

