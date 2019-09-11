      <?php
      DEFINE ('DB_USER', 'tutorial_script'); // Insert your database username into the quotes.
      DEFINE ('DB_PASSWORD', 'tutorialcode'); // Insert your database password into the quotes.
      DEFINE ('DB_HOST', 'localhost'); // This will most likely stay the same.
      DEFINE ('DB_NAME', 'tutorial_news'); Insert your actual database name in the quotes.
      $dbc = @mysql_connect (DB_HOST, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL: ' . mysql_error());
      @mysql_select_db (DB_NAME) OR die('Could not select the database: ' . mysql_error() );
      ?>

