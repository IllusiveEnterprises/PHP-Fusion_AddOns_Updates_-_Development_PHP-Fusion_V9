/*
Author: Benjamin Eckstein
http://www.umingo.de/
 
You can use this code in any manner so long as the author's
name, Web address and this disclaimer is kept intact.
********************************************************
Usage Sample:
<div id="cID">Init<script>countdown(100000,'cID');</script></div>
*/
 
function countdownd1dtw(time,id){
 
  //time brauchen wir später noch
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
  s = (s < 10) ? ""+s : s;
 
  // Ausgabestring generieren
  strZeit = "<b><font color='#FF0000'><img align='absmiddle' src='/infusions/D1_dice_to_win_panel/images/stop.png'/> Bitte Warten (" + s + ") - Reload Sperre noch aktiv <img align='absmiddle'  src='/infusions/D1_dice_to_win_panel/images/stop.png'/></font><br></b>";
 
  // Falls der Countdown noch nicht zurückgezählt ist
  if(time > 0)
  {
    //Countdown-Funktion erneut aufrufen
    //diesmal mit einer Sekunde weniger
    window.setTimeout('countdownd1dtw('+ --time+',\''+id+'\')',1000);
  }
  else
  {
    //führe eine funktion aus oder refresh die seite
    //dieser Teil hier wird genau einmal ausgeführt und zwar 
    //wenn die Zeit um ist.
    strZeit = "<b><font color='#00c000'><img align='absmiddle' src='/infusions/D1_dice_to_win_panel/images/ok.png'/> Du darfst w&uuml;rfeln - Reload Sperre FREI <img align='absmiddle'  src='/infusions/D1_dice_to_win_panel/images/ok.png'/></font><br></b>";
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

////

function countdownd1dtw2(time,id){
 
  //time brauchen wir später noch
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
  s = (s < 10) ? ""+s : s;
 
  // Ausgabestring generieren
  strZeit2 = "<b><font color='#FF0000'><img align='absmiddle' src='/infusions/D1_dice_to_win_panel/images/stop.png'/> Bitte Warten (" + s + ") - Reload Sperre noch aktiv <img align='absmiddle'  src='/infusions/D1_dice_to_win_panel/images/stop.png'/></font><br></b>";
 
  // Falls der Countdown noch nicht zurückgezählt ist
  if(time > 0)
  {
    //Countdown-Funktion erneut aufrufen
    //diesmal mit einer Sekunde weniger
    window.setTimeout('countdownd1dtw2('+ --time+',\''+id+'\')',1000);
  }
  else
  {
    //führe eine funktion aus oder refresh die seite
    //dieser Teil hier wird genau einmal ausgeführt und zwar 
    //wenn die Zeit um ist.
    strZeit2 = "<input type='submit' name='dice_to' value='w&uuml;rfeln' class='button' />";
  }
  // Ausgabestring in Tag mit id="id" schreiben
  document.getElementById(id).innerHTML = strZeit2;
}
//Helfer Funktion erlaubt Counter auch ohne Timestamp
//countdown22(Tage,Stunden,Minuten,Sekunden,ID)
function countdown22(d,h,m,s,id)
{
  countdownd1dtw2(d*60*60*24+h*60*60+m*60+s,id);
}
-->

