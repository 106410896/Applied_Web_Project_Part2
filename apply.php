<!-- use http://localhost/Applied_Web_Project_Part2/index.php to debug -->

<?php

/* variables declared for dynamic page author, title setting and stylesheet loading */
    $page_author = "Alagarsamy Chandrasekar Shashanth Kumar";
    $page_title = "Apply";
    $page_description = "Applied Web Project - Apply page (Fantastic5)";

    $page_stylesheets = [
        "styles/apply.css",
        "styles/apply-layout.css"
    ];

/* include file 'header.inc' used for header to avoid repetition */
    include 'header.inc';

?>

    <body>

      <!-- Embedded CSS example -->
        <style>
            main h1 {
                text-align: center;
                margin-top: 40px;
                margin-bottom: 40px;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            }
        </style>

      <!-- include file 'nav.inc' used for navigation bar to avoid repetition -->
      <?php include 'nav.inc'; ?>

      <!-- 'main' is a semantic tag that tells the browser where all the page-specific unique content lives. -->
      <main>

         <h1>Apply</h1>

        <!-- form created -->
        <form action="https://mercury.swin.edu.au/it000000/formtest.php" method="post">

            <!-- Job Reference number element-->
                <label for="job-ref-num">Job Reference Number:</label>
                <input type="text" id="job-ref-num" name="job-ref-num" pattern="[0-9]{6}" required aria-describedby="job-ref-hint" aria-required="true">

                <!-- In-Line CSS example -->

                <span id="job-ref-hint" style="display: block; font-size: 0.85em; color: #555555; margin-top: 5px;">Must be exactly 6 digits (e.g. 123456).</span>

                <br>

            <!-- Personal Details fieldset-->
            <fieldset class="personal-details-main-fieldset">

                <legend>Personal Details</legend>

                <!-- First Name Field -->
                 <div class="personal-details">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first-name" pattern="[A-Za-z\s]{1,20}" required aria-required="true">
                 </div>

                <!-- Last Name Field -->
                 <div class="personal-details">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last-name" pattern="[A-Za-z\s]{1,20}" required aria-required="true">
                 </div>

                <!-- Date of birth Field -->
                 <div class="personal-details">
                    <label for="DOB">Date of birth:</label>
                    <input type="date" id="DOB" name="DOB" required aria-required="true">
                 </div>

                <!-- Radio Buttons for Gender fields -->
                 <fieldset class="gender-subgroup" aria-labelledby="gender-legend">
                    <legend id="gender-legend">Gender</legend>

                    <input type="radio" id="male" name="gender" value="Male" required aria-required="true">
                    <label for="male">Male</label>

                    <input type="radio" id="female" name="gender" value="Female" required aria-required="true">
                    <label for="female">Female</label>

                 </fieldset>
            </fieldset>


            <!-- Address fieldset -->
            <fieldset class="address-main-fieldset">

                <legend>Address</legend>

                <!-- Street Address Field -->
                 <div class="address">
                    <label for="street-address">Street Address:</label>
                    <input type="text" id="street-address" name="street-address" pattern="[A-Za-z0-9\s]{1,40}" required aria-required="true">
                 </div>

                <!-- Address Field -->
                 <div class="address">
                    <label for="suburb-town">Suburb/Town:</label>
                    <input type="text" id="suburb-town" name="suburb-town" pattern="[A-Za-z0-9\s]{1,40}" required aria-required="true">
                 </div>

                <!-- Dropdown list for state selection-->
                 <div class="state-subgroup">
                    <label for="state">State</label>
                    <select id="state" name="state" required aria-required="true">

                        <option value="">Please select</option>
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>

                    </select>
                 </div>

                <!-- Postcode field -->
                 <div class="address">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode" pattern="[0-9]{4}" required aria-required="true">
                 </div>

            </fieldset>


            <!-- Contact Details fieldset -->
            <fieldset class="contact-details-main-fieldset">

               <legend>Contact Details</legend>

               <!-- Email field -->
               <div class="contact-details">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required aria-required="true">
               </div>

               <!-- Phone number field -->
               <div class="contact-details">
                  <label for="phone-number">Phone Number:</label>
                  <input type="text" id="phone-number" name="phone-number" pattern="[0-9]{8,12}" required aria-required="true">
               </div>

            </fieldset>
            

            <!-- Skills And Qualifications fieldset -->
            <fieldset class="skills-and-qualifications-main-fieldset" role="group" aria-labelledby="skills-legend" >

               <legend id="skills-legend">Skills and Qualifications</legend>

               <!-- the following are the checkbox fields for the 'Skills' field -->

               <div class="skills-subgroup">
                  <label for="html">HTML</label>
                  <input type="checkbox" id="html" name="skills[]" value="HTML" checked>
               </div>

               <div class="skills-subgroup">
                  <label for="css">CSS</label>
                  <input type="checkbox" id="css" name="skills[]" value="CSS">
               </div>

               <div class="skills-subgroup">
                  <label for="javascript">JavaScript</label>
                  <input type="checkbox" id="javascript" name="skills[]" value="JavaScript">
               </div>

               <div class="skills-subgroup">
                  <label for="php">PHP</label>
                  <input type="checkbox" id="php" name="skills[]" value="PHP">
               </div>

               <div class="skills-subgroup">
                  <label for="mysql">MySQL</label>
                  <input type="checkbox" id="mysql" name="skills[]" value="MySQL">
               </div>


               <!-- 'Other Skills' text area field-->
               <div class="other-skills-subgroup">
                  <label for="other-skills">Other skills:</label>
                  <textarea id="other-skills" name="other-skills" rows="10" cols="50" placeholder="List any other relevant skills or qualifications..."></textarea>
               </div>


            </fieldset>


            <!-- 'Submit' and 'Reset' buttons -->

            <div class="end-of-form-buttons">
               <input type="submit" value="Submit">
            </div>
            
            <div class="end-of-form-buttons">
               <input type="reset" value="Reset Form">
            </div>

        </form>

      </main>


    </body>
</html>