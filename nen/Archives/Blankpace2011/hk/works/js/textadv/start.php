<p>A text adventure taking place in the town of Mistville. JavaScript must be enabled to play. 
Currently works only on Firefox. Still under development...</p>

<p>Current place: In the middle of the Mistville</p>
<p>
You have just graduated from the SNA (Secret Ninja Academy) and ranked top of your
class. You left the building through the secret passage that lead right to the middle
of your hometown, the Mistville. You must now choose what will you do from now on.
</p>
<ol>
		<li>Go back to the SNA.</li>
		<li>Go home.</li>
		<li>Commit seppuku.</li>
</ol>

<script type="text/javascript">
		ch1 = "You chose to go back to the building of SNA. <a href='c1-1'>Continue...</a>";
		ch2 = "You chose to go home. <a href='c2-1'>Continue...</a>";
		ch3 = "Your lunacy took control and you killed yourself. :( <br />THE END.";
		
		function choise1() {
				document.getElementById("description").innerHTML = ch1;
		}
		function choise2() {
				document.getElementById("description").innerHTML = ch2;
		}
		function choise3() {
				document.getElementById("description").innerHTML = ch3;
		}
</script>

<p id="description">
		<input type="button" value="Choose 1" onClick="choise1()" /> 
		<input type="button" value="Choose 2" onClick="choise2()" /> 
		<input type="button" value="Choose 3" onClick="choise3()" />
</p>
