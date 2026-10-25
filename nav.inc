<header>

    <nav class="navbar">
      <div class="logo">
        <a 
        href="index.php"><img src="images/FlyAnywhere.png" alt="FlyAnywhere Logo">
        </a>
      </div>

      <!-- Navigation bar -->
      <ul class="nav-links">
        <?php 
        
          $pages = [
            'About' => 'about.php',
            'Jobs' => '_jobs.php',
            'Apply' => 'apply.php',
            'Travel Planner' => 'Travelplanner.php'
          ];

          $current_page = basename($_SERVER['PHP_SELF']);

          foreach ($pages as $label => $filename) {
            $active_class = ($current_page == $filename) ? 'current_page' : '';

            /* applied cta-btn class to apply page if active, else, defaults to dynamically modifying current class */
            if ($filename == 'apply.php') {
              $class_list = trim("cta-btn $active_class");
              echo "<li><a href=\"$filename\" class=\"$class_list\">$label</a></li>";
            } else {
              $class_attr = $active_class ? "class=\"$active_class\"" : "";
              echo "<li><a href=\"$filename\" $class_attr>$label</a></li>";
            }
          }
        ?>
      </ul>
    </nav>
    
  </header> 