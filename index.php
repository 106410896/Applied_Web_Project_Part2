<!-- use http://localhost/Applied_Web_Project_Part2/index.php to debug -->

<?php

/* test commmit */
/* variables declared for dynamic page author, title setting and stylesheet loading */
    $page_author = "Manas and Kshitij";
    $page_title = "Fly Anywhere";
    $page_description = "Tourism and Travel Technology Platform Careers Portal";

    $page_stylesheets = [
        "styles/index.css"
    ];

/* include file 'header.inc' used for header to avoid repetition */
    include 'header.inc';

?>

<body>

    <!-- include file 'nav.inc' used for navigation bar to avoid repetition -->
    <?php include 'nav.inc'; ?>

    <main>
          <!-- Adding Logo and slogan -->
        <div class="brand">

           <img src="images/FlyAnywhere.png" alt="FlyAnywhere Logo" style="width:50px; height:50px;">

             <div>

               <h1>FlyAnywhere</h1>
               <p><em>Connecting People, Places and Technology.</em></p>

             </div>

        </div>

           <!-- Company intro- Used copilot to help me write the company intro. Didn't use it for writing the code in this section. -->
<section class="company-intro">
    <h2>Welcome to FlyAnywhere</h2>
    <p class="intro-lead">
       FlyAnywhere is dedicated to improving the travel experience
       through innovative digital solutions. We specialise in developing user-friendly
       travel websites, online booking systems, and tourism management platforms.
       Our goal is to make travelling easier, more accessible, and more convenient
       for individuals and businesses around the world.
    </p>


    <div class="trust-box">
        <div class="box">
            <h3> Innovative Technology</h3>
            <p>We develop modern digital solutions that help travellers plan trips, book services, and explore destinations easily.</p>
        </div>
        
        <div class="box">
            <h3> Customer Satisfaction</h3>
            <p>Our customers are our priority. We provide reliable and user-friendly platforms to make every travel experience enjoyable.</p>
        </div>

        <div class="box">
            <h3> Reliable Travel Services</h3>
            <p>Our technology supports efficient booking systems, travel management, and access to important travel information.</p>
        </div>
    </div>
</section>
 <!-- Adding image -->
<figure class="hero">
    <img src="images/World map.png" alt="World map image">
    </figure>
<!-- Why Join Us Section- Used copitlot to help write the code and paragraph in this section, but understood the code. -->
<section class="why-join-us">
    <h2>Why Build Your Career with Us?</h2>
    <p class="bold-text">
       At FlyAnywere, <strong>we believe that our employees
       are the key to our success.</strong> We provide opportunities to develop technical
       skills, work on innovative tourism projects, and contribute to the growing
       travel technology industry. Whether you are a web developer, software engineer,
       or technology enthusiast, <strong>you will find a supportive environment
       where teamwork, creativity, and innovation are encouraged.</strong>
    </p>
    
    
    <div class="power-box">
        <p>
           Ready to begin your career in travel technology?
           <strong>Explore our current job opportunities or apply today
           to become part of our growing team.</strong>

        </p>
        <a href="jobs.php" class="button">View Open Roles</a>
        <a href="apply.php" class="button">Apply</a>
    </div>
</section>
           
 <!-- Used copilot to help write the code in this section but understood the code. -->
        <div>
        <section>
            <h2>Recruitment Overview</h2>
            <table>
    <caption>Hiring Summary</caption>
    <tr>
        <th>Category</th>
        <th>Details</th>
    </tr>
    <tr>
        <td>Open Roles</td>
        <td>
            <ul>
               <li>Travel Technology Web Developer</li>
               <li>Front-End Web Developer</li>
               <li>Full Stack Developer</li>

            </ul>
        </td>
    </tr>
    <tr>
        <td>Locations</td>
        <td>Melbourne, Sydney, Brisbane</td>
    </tr>
</table>
        </section>
        
    </div>
        <!-- Aboriginal & Torres Strait Islander acknowledgement- Used copilot to help write the respect and inclusion paragraph. Didn't use it to write the code in this section.-->
        <section>
            <h2>Respect and Inclusion</h2>
            <p>
                We acknowledge the Traditional Custodians of the lands on which we operate.
                We pay our respects to Elders past and present and recognise the ongoing
                contributions of Aboriginal and Torres Strait Islander peoples.
            </p>

            <p>
               We encourage applications from Aboriginal and Torres Strait Islander peoples
               and are committed to providing culturally safe and inclusive career opportunities
               within the tourism and technology industries.

             <!-- Used copilot to help write the awareness about cybercrimes paragraph. Didn't use it to help write code here. -->
            <h3>Awarness about safety</h3>
            <p> Travelling is an exciting experience, but it is important to stay informed
               about potential risks. Travellers should be aware of online booking scams,
               fraudulent travel websites, and misleading accommodation advertisements.
               <strong>Understanding these risks helps travellers make safer decisions.
               Always use trusted booking platforms and verify travel information
               before making payments.</strong> At FlyAnywhere, we are committed to
                helping travellers make informed and safer travel decisions by providing reliable travel information and trusted resources.
           </p>
    </p>

       </section>

    </main>

    
    <!-- include file 'footer.inc' used for footer to avoid repetition -->
    <?php include 'footer.inc'; ?>

</body>
</html>

