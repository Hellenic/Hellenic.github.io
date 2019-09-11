<p>Current place: The Secret Ninja Academy</p>
<p>
While you were skittering back to the academy, you saw few rats at the passage
and exterminated them with your shurikens and superior skill... ...You are now at the
main hall of the academy, what will you?
</p>
<ol>
		<li>Talk to someone.</li>
		<li>Go home.</li>
		<li>Commit seppuku.</li>
</ol>

<script type="text/javascript">
		ch1 = "You want to talk to someone. Who will you talk to? <a href='c1-11'>The Sensei</a> <a href='c1-12'>Ninja fellow</a>";
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
