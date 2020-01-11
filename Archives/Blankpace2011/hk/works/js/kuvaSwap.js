ankka1 = new Image(150,155);
ankka1.src = "ankka/ankka.jpg";
random1 = new Image(150,155);
random1.src = "ankka/random1.jpg";
random2 = new Image(150,155);
random2.src = "ankka/random2.jpg";
random3 = new Image(150,155);
random3.src = "ankka/random3.jpg";
lista = [random1, random2, random3];
function change_image(img, ref)
{
 		document.images[img].src = ref.src
} 
