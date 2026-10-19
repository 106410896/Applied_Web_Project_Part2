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

      <!-- Definition list -->
      <dl>
        <dt>Ollie Madu</dt>
        <dd>
          Responsible for the HTML structure and page layout of
          <code>jobs.html</code>.
        </dd>

        <dt>Manas Alwani</dt>
        <dd>
          Responsible for <code>index.html</code>, code validation and helping
          the team write valid HTML5.
        </dd>

        <dt>Kshitij Shetty</dt>
        <dd>
          Responsible for finding suitable images, adding APA 7 references
          where required and helping write HTML5.
        </dd>

        <dt>Isaac Malual</dt>
        <dd>
          Responsible for <code>about.php</code> and managing the team's Jira
          project.
        </dd>

        <dt>Shashanth Kumar</dt>
        <dd>
          Responsible for <code>apply.php</code>, CSS development, deadline
          reminders and managing the GitHub repository.
        </dd>
      </dl>
    </section>

    <section id="member-quotes">
      <h2>Quotes from Our Members</h2>

      <article>
        <h3>Ollie Madu</h3>
        <blockquote lang="">
          <p>"There is no tooth fairy, there is no easter bunny, and there is
            no Queen of England."</p>
        </blockquote>
         
      </article>

      <article>
        <h3>Manas Alwani</h3>
        <blockquote lang="">
          <p>"Knowing others is intelligence, knowing yourself is true wisdom."</p>
        </blockquote>
         
      </article>

      <article>
        <h3>Kshitij Shetty</h3>
        <blockquote lang="">
          <p> Only the fiercest wind reveals the strongest grass</p>
        </blockquote>
         
      </article>

      <article>
        <h3>Isaac Malual</h3>
        <blockquote lang="">
          <p>THE ONE PIECE IS REALLLLLLLLL</p>
        </blockquote>
         
      </article>

      <article>
        <h3>Shashanth Kumar</h3>
        <blockquote lang="">
          <p>"Nee Strong aanavantha na adha illangala un emotion enakku puriyudhu ana antha glove nammba ellarayavidayum SAKTHI vaainthathu"</p>
        </blockquote>
         
      </article>
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
          <tr>
            <th scope="row">Ollie</th>
            <td>106510262</td>
            <td>I like to draw comics.</td>
            <td>Jobs page designer</td>
          </tr>

          <tr>
            <th scope="row">Manas</th>
            <td>106543763</td>
            <td> I love playing chess and cricket</td>
            <td>Home page and validation</td>
          </tr>

          <tr>
            <th scope="row">Kshitij</th>
            <td>106378541</td>
            <td>I Love playing Basketball</td>
            <td>Created TravelPlaner page and worked on Main Page Css too</td>
          </tr>

          <tr>
            <th scope="row">Isaac</th>
            <td>105919389</td>
            <td>I like skating</td>
            <td>About page and Jira</td>
          </tr>

          <tr>
            <th scope="row">Shashanth</th>
            <td>106410896</td>
            <td>I'm an aspiring filmmaker and writer</td>
            <td>Application page, CSS and GitHub</td>
          </tr>
        </tbody>
      </table>
    </section>

  </main>


</body>
</html>