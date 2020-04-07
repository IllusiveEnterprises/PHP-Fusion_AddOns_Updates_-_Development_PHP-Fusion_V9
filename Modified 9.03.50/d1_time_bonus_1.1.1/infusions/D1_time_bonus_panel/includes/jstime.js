/*
Author: Benjamin Eckstein
http://www.umingo.de/
 
You can use this code in any manner so long as the author's
name, Web address and this disclaimer is kept intact.
********************************************************
Usage Sample:
<div id="cID">Init<script>countdown(100000,'cID');</script></div>
*/
 
function countdown(time,id){
 
  //time brauchen wir sp�ter noch
  t = time;
 
  //Tage berechnen
  d = Math.floor(t/(60*60*24)) % 24; 
 
  // Stunden berechnen
  h = Math.floor(t/(60*60)) % 24;
 
 
  // Minuten berechnen
  // Sekunden durch 60 ergibt Minuten
  // Minuten gehen von 0-59
  //also Modulo 60 rechnen
  m = Math.floor(t/60) %60;
 
  // Sekunden berechnen
  s = t %60;
 
  //Zeiten formatieren
  d = (d >  0) ? d+"d ":"";
  h = (h < 10) ? "0"+h : h;
  m = (m < 10) ? "0"+m : m;
  s = (s < 10) ? "0"+s : s;
 
  // Ausgabestring generieren
  strZeit =d + h + ":" + m + ":" + s;
 
  // Falls der Countdown noch nicht zur�ckgez�hlt ist
  if(time > 0)
  {
    //Countdown-Funktion erneut aufrufen
    //diesmal mit einer Sekunde weniger
    window.setTimeout('countdown('+ --time+',\''+id+'\')',1000);
  }
  else
  {
    //f�hre eine funktion aus oder refresh die seite
    //dieser Teil hier wird genau einmal ausgef�hrt und zwar 
    //wenn die Zeit um ist.
    strZeit = "    <form action='/infusions/D1_time_bonus_panel/D1_time_bonus_holen.php?btholen=true' method='POST'><input class='button' type='submit' value='Bonus holen' name='btholen'></form>";
  }
  // Ausgabestring in Tag mit id="id" schreiben
  document.getElementById(id).innerHTML = strZeit;
}
//Helfer Funktion erlaubt Counter auch ohne Timestamp
//countdown2(Tage,Stunden,Minuten,Sekunden,ID)
function countdown2(d,h,m,s,id)
{
  countdown(d*60*60*24+h*60*60+m*60+s,id);
}

