<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Raid group setup generator</title>
    </head>
    <body>
        
        <?php
            // Read JSON
            $file = file_get_contents("members.json");
            $json = json_decode($file);

            // Convert JSON arrays to arrays
            $groups = array();
            foreach ($json->{"groups"} as $group)
            {
                array_push($groups, $group);
            }
            $healers = array();
            foreach ($json->{"healers"} as $group)
            {
                array_push($healers, $group);
            }
            $dps = array();
            foreach ($json->{"dps"} as $group)
            {
                array_push($dps, $group);
            }
            $tanks = array();
            foreach ($json->{"tanks"} as $group)
            {
                array_push($tanks, $group);
            }

            // Roles per group
            $tanknum = 2;
            $healernum = 3;
            $dpsnum = 5;

            // Create and print all groups
            foreach ($groups as $group)
            {
                echo "<h1>" . $group . "</h1>";
                echo "<table border=1>";

                // Get random, un-used tank for group
                for ($i=0; $i<$tanknum; $i++)
                {
                    $tankid = rand(0, count($tanks)-1);
                    echo "<tr><td width=100px>Tank</td><td width=200px>" . $tanks[$tankid] . "</td></tr>";
                    unset($tanks[$tankid]);
                    $tanks = array_values($tanks);
                }

                // Get random, un-used healer
                for ($i=0; $i<$healernum; $i++)
                {
                    $healerid = rand(0, count($healers)-1);
                    echo "<tr><td>Healer</td><td>" . $healers[$healerid] . "</td></tr>";
                    unset($healers[$healerid]);
                    $healers = array_values($healers);
                }

                // Get random, un-used dps
                for ($i=0; $i<$dpsnum; $i++)
                {
                    $dpsid = rand(1, count($dps)-1);
                    echo "<tr><td>DPS</td><td>" . $dps[$dpsid] . "</td></tr>";
                    unset($dps[$dpsid]);
                    $dps = array_values($dps);
                }

                echo "</table>";
            }
        ?>

    </body>
</html>
