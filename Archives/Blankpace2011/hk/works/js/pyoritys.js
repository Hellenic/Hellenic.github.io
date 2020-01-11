i = 1;
anim = true;

function pyoritaTekstia() {
  i++;
  pyoritys = document.getElementById("pyoritys");
  x = 50+Math.sin(i/10)*100;
  y = Math.cos(i/10)*100;
  pyoritys.style.left = x+"px";
  pyoritys.style.top = y+"px";
  pyoritys.innerHTML = "<img alt='cactuar' src='cactuar.gif' />";
  if (anim) setTimeout("pyoritaTekstia()", 50);
}

function play() {
  if (!anim) {
    anim = true;
    pyoritaTekstia();
    }
}

function stop() {
  anim = false;
}
