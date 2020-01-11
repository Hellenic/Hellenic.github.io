<?php
		/*
				Linkki tiettyyn kuvaan tulee näin:
				Esim. kuva 4
				www.testi.net/nav/index.php?pic=4
		*/
		
		
		// Kuvien sijainti, muista loppuun /
		$path = "http://spals.blankpace.net/comic/";
		
		// Kuvien määrä
		$lastpic = 4;


////////////////////////////////////////////////////////////////////////////////
		
		if (htmlentities($_GET['pic'])) {
				$pic = htmlentities($_GET['pic']);
		} else {
				$pic = $lastpic;
		}
		$picpath =  $path . $pic . ".jpg";
		list($width, $height) = getimagesize($picpath);
		
		
		echo "<p>";
		
		// ******* FIRST NAPPI *************
		if ($pic <= 1) {
				echo "&lt;&lt; First || ";
		} else {
				echo "<a href='?pic=1'>&lt;&lt; First</a> || ";
		}
		
		
		// ******* PREVIOUS NAPPI *************
		if ($pic <= 1) {
				echo "&lt; Previous || ";
		} else {
				$previous = $pic - 1;
				echo "<a href='?pic=${previous}'>&lt; Previous</a> || ";
		}
		
		
		// ******* NEXT NAPPI *************
		if ($pic >= $lastpic) {
				echo "Next &gt; || ";
		} else {
				$next = $pic + 1;
				echo "<a href='?pic=${next}'>Next &gt;</a> || ";
		}
		
		
		// ******* LAST NAPPI *************
		if ($pic >= $lastpic) {
				echo "Last &gt;&gt;";
		} else {
				echo "<a href='?pic=$lastpic'>Last &gt;&gt;</a>";
		}
		
		echo "</p>";		
		
		
		echo "<table>";
		echo "<tr><td>";
		echo "<img alt='[Picture]' src='$picpath' width='$width' height='$height' /></a>";
		echo "</td></tr>";
		echo "</table>";
		
?>
