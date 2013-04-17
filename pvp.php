<?php

#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribución de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para más información: www.soul-adventure.net							#
# *                                                          				#
#############################################################################

function pvp() {
global $userrow, $numqueries;

if (isset($_POST['call'])) { //Comprobamos el oro de ambos personajes y su existencia
   $query = doquery("SELECT*FROM {{table}} WHERE charname='".$_POST['enemigo']."' LIMIT 1", "usuarios");
   $row = mysql_fetch_array($query);
   $maxapuesta = $userrow["gold"];
   $maxenemigo = $row["gold"];
   
 if ($_POST['apuesta'] > $maxapuesta) { display("<div class='contenido2'>Tu apuesta es muy alta.<p><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error"); die(); }
elseif ($_POST['apuesta'] > $userrow["gold"]) { display("</div>No tienes esa cantidad de oro.<p><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error"); die(); }
elseif ($_POST['apuesta'] < "0") { display("<div class='contenido2'>La apuesta tiene que ser mayor que 0.<br /><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error"); die(); }
elseif ($_POST['apuesta'] == "0") { display("<div class='contenido2'>La apuesta tiene que ser mayor que 0.<br /><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error"); die(); }
elseif ($_POST['enemigo'] == "") { display("<div class='contenido2'>Ese personaje no existe.<br><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error"); die(); }
elseif ($_POST['enemigo'] == $userrow['charname']) { display("<div class='contenido2'>No puedes desafiarte a ti mismo.<br><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error"); die(); }
elseif ($_POST['apuesta'] > $maxenemigo) { display("<div class='contenido2'>Tu rival no tiene tanto oro para apostar!<br /><a href=\"index.php?do=desafiar\">Volver</a></div>", "Error");

} else {

$actualizaroro = $userrow["gold"] - $_POST['apuesta']; //Restamos el oro del desafiador al enviar el desafio
$nivelpvp = $userrow["strength"] + $userrow["dexterity"] + $userrow["attackpower"] + $userrow["defensepower"] + $userrow["currenthp"] + $userrow["currentmp"]; 
doquery("INSERT INTO {{table}} SET id='', desafiador='".$userrow["id"]."', apuesta='".$_POST['apuesta']."', charname='".$userrow["charname"]."', oponente='".$row["id"]."', nivelpvp='$nivelpvp'", "pvp");

doquery("UPDATE {{table}} SET gold='$actualizaroro' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios"); 

$page .= "<div class='contenido2'>Desafio enviado!<br /><a href=\"index.php\">Volver a la ciudad</a> - <a href=\"index.php?do=arena\">Ir a la Arena de Combate</a>.</div>"; } 

} else {

$maxapuesta = $userrow["gold"]; //Menu Desafiar
	$page = "<div class='titulo'>Desafiar</div>
		<div class='contenido2'>
 		De que el oponente acepte tu desafio el comite de lucha te enviara un mensaje con el resultado de la batalla.<br /><br />Rival = Nombre del oponente.<br />Apuesta = El ganador se lleva todo el oro.<br />
		<form action=index.php?do=desafiar method=post><br />
		Rival: <input type=text name=enemigo size=10><br />
		La apuesta máxima es de <strong>$$maxapuesta</strong> de oro<br />
		Apuesta: <input type=text name=apuesta size=10><br />
		<input type=submit value=Enviar desafio name=call></form><br /><br />
		<a href=\"index.php\">Volver a la ciudad</a> - <a href=\"index.php?do=arena\">Ir a la Arena de Combate</a></div>"; }
	
	
	display($page, "Desafiar");
}

function pvp1() { //Ver lista de desafios pendientes
global $userrow, $numqueries;

$page = "<div class='titulo'>Desafios pendientes</div><div class='contenido2'>";
      $page .= "<table width=500 class=title><tr><td>Desafio</td></tr></table>";
    $page .= "<table width=500><tr class=title><td></td><td width=\"200\"><strong>Oponente</strong></td><td><strong>Apuesta</strong></td><td widh=150></td><td></td></tr>"; 
 $query = doquery("SELECT*FROM {{table}} WHERE oponente='".$userrow["id"]."'", "pvp");
 $rank = 1;
	while ($row = mysql_fetch_array($query)) {
	      		   $page .= "<tr><td><b>$rank</b></td><td>".$row["charname"]."</td><td >$".$row["apuesta"]."</td><td><center><a href=\"index.php?do=pvp1:".$row["id"]."\">[ACEPTAR]</a></center></td><td><center><a href=\"index.php?do=pvp2:".$row["id"]."\">[CANCELAR]</a></center></td></tr>\n";
        
    $rank++;
	}
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"100%\">No tienes desafios.</td></tr>\n"; }
    $page .= "</table>";

$page .= "<center><a href=\"index.php\">Volver a la ciudad</a> - <a href=\"index.php?do=arena\">Ir a la Arena de Combate</a></center></div>";
	display($page, "Desafios");
	
}

function pvpenviados() { //Ver lista de desafios enviados
global $userrow, $numqueries;

$page = "<div class='titulo'>Desafios enviados</div><div class='contenido2'>";
      $page .= "<table width=500 class=title><tr><td>Desafios enviados</td></tr></table>";
    $page .= "<table width=500><tr class=title><td></td><td width=\"200\"><strong>Jugador Desafiado</strong></td><td><strong>Apuesta</strong></td><td widh=150></td><td></td></tr>"; 
 $query = doquery("SELECT*FROM {{table}} WHERE desafiador='".$userrow["id"]."'", "pvp");
 $rank = 1;
	while ($row = mysql_fetch_array($query)) {
	 $oponente = $row["oponente"];
	 $selecciono2 = doquery("SELECT * FROM {{table}} WHERE id='$oponente'", "usuarios");
     $arow = mysql_fetch_array($selecciono2);
	      		   $page .= "<tr><td><b>$rank</b></td><td>".$arow["charname"]."</td><td >$".$row["apuesta"]."</td><td><center><a href=\"index.php?do=pvp3:".$row["id"]."\">[CANCELAR]</a></center></td></tr>\n";
        
    $rank++;
	}
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"100%\">No has enviado ningun desafio.</td></tr>\n"; }
    $page .= "</table>";

$page .= "<center><a href=\"index.php\">Volver a la ciudad</a> - <a href=\"index.php?do=arena\">Ir a la Arena de Combate</a></center></div>";
	display($page, "Desafios");
	
}

 function pvp2($id) {   //En esta funcion se desarolla el combate
global $userrow, $numqueries;

 $query = doquery("SELECT*FROM {{table}} WHERE id='$id'", "pvp");
$row = mysql_fetch_array($query);

 $desafiadorquery = doquery("SELECT*FROM {{table}} WHERE id='".$row["desafiador"]."'", "usuarios"); 
$desafiadorrow = mysql_fetch_array($desafiadorquery);


if ($row["nivelpvp"] > $userrow["nivelpvp"]) //Pierde el que acepta el desafio
 { $page.= "<div class='contenido2'>";
 $page.= "<table><tr><td>".$userrow["charname"]."</td><td>Versus</td><td>".$row["charname"]."</td></tr><tr><td>".$userrow["nivel"]."</td><td>Nivel</td><td>".$desafiadorrow["nivel"]."</td></tr><tr><td>".$userrow["strength"]."</td><td>Fuerza</td><td>".$desafiadorrow["strength"]."</td></tr><tr><td>".$userrow["dexterity"]."</td><td>Agilidad</td><td>".$desafiadorrow["dexterity"]."</td></tr><tr><td>".$userrow["attackpower"]."</td><td>Poder de<br />Ataque</td><td>".$desafiadorrow["attackpower"]."</td></tr><tr><td>".$userrow["defensepower"]."</td><td>Poder de<br />Defensa</td><td>".$desafiadorrow["defensepower"]."</td></tr><tr><td>".$userrow["currenthp"]."</td><td>Vida<br />Actual</td><td>".$desafiadorrow["currenthp"]."</td></tr><tr><td>".$userrow["currentmp"]."</td><td>Mana<br />Actual</td><td>".$desafiadorrow["currentmp"]."</td></tr><tr><td>".$userrow["nivelpvp"]."</td><td>Resultado de<br />la Batalla</td><td>".$row["nivelpvp"]."</td></tr><br />Has perdido!</table><form action=index.php?do=arena method=post><input type=submit value='Volver a la Arena de Combate' name=perder></div>";  
 
 $query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "pvp");
$row = mysql_fetch_array($query);
$apuesta = $row["apuesta"];
$oponente = $row["oponente"];
$desafiador = $row["desafiador"];
$query2= doquery("SELECT gold FROM {{table}} WHERE id='$oponente'", "usuarios");
$qrow = mysql_fetch_array($query2);
$orooponente = $qrow["gold"];
$query4= doquery("SELECT gold FROM {{table}} WHERE id='$desafiador'", "usuarios");
$qrow2 = mysql_fetch_array($query4);
$orodesafiador = $qrow2["gold"];
$oroperdido = $orooponente - $apuesta;
$oroganado = $orodesafiador + $apuesta * 2;
$query3 = doquery("UPDATE {{table}} SET gold='$oroperdido' WHERE id='$oponente' LIMIT 1", "usuarios");
$query6 = doquery("UPDATE {{table}} SET gold='$oroganado' WHERE id='$desafiador' LIMIT 1", "usuarios");
$perdedor = doquery("UPDATE {{table}} SET pvpperdidos=pvpperdidos+1 WHERE id=".$userrow["id"], "usuarios");
$ganador = doquery("UPDATE {{table}} SET pvpganados=pvpganados+1 WHERE id=".$row["desafiador"], "usuarios");
$enviomensaje = doquery("INSERT INTO {{table}} SET Remitente='Comite de lucha', Destinatario='".$row["desafiador"]."', message='El comite de lucha ha decidido que has ganado tu lucha contra ".$userrow["charname"].".Este es un mensaje automatico, no responder.', title='Combate', Date=NOW()", "mail");
$query8 = doquery("DELETE FROM {{table}} WHERE id='$id'", "pvp");

}
 
 elseif($row["nivelpvp"] == $userrow["nivelpvp"]) //Empate
 { $page.= "<div class='contenido2'>";
$page.= "<table><tr><td>".$userrow["charname"]."</td><td>Versus</td><td>".$row["charname"]."</td></tr><tr><td>".$userrow["nivel"]."</td><td>Nivel</td><td>".$desafiadorrow["nivel"]."</td></tr><tr><td>".$userrow["strength"]."</td><td>Fuerza</td><td>".$desafiadorrow["strength"]."</td></tr><tr><td>".$userrow["dexterity"]."</td><td>Agilidad</td><td>".$desafiadorrow["dexterity"]."</td></tr><tr><td>".$userrow["attackpower"]."</td><td>Poder de<br />Ataque</td><td>".$desafiadorrow["attackpower"]."</td></tr><tr><td>".$userrow["defensepower"]."</td><td>Poder de<br />Defensa</td><td>".$desafiadorrow["defensepower"]."</td></tr><tr><td>".$userrow["currenthp"]."</td><td>Vida<br />Actual</td><td>".$desafiadorrow["currenthp"]."</td></tr><tr><td>".$userrow["currentmp"]."</td><td>Mana<br />Actual</td><td>".$desafiadorrow["currentmp"]."</td></tr><tr><td>".$userrow["nivelpvp"]."</td><td>Resultado de<br />la Batalla</td><td>".$row["nivelpvp"]."</td></tr><br />Has empatado!</table><form action=index.php?do=arena method=post><input type=submit value='Volver a la Arena de Combate' name=empate></div>";
 
 $query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "pvp");
$row = mysql_fetch_array($query);
$apuesta = $row["apuesta"];
$desafiador = $row["desafiador"];
$query2= doquery("SELECT gold FROM {{table}} WHERE id='$desafiador'", "usuarios");
$qrow = mysql_fetch_array($query2);
$apuesta2 = $qrow["gold"];
$newgold = $apuesta2 + $apuesta;
$query3 = doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='$desafiador' LIMIT 1", "usuarios");
$empate = doquery("UPDATE {{table}} SET pvpempatados=pvpempatados+1 WHERE id=".$userrow["id"], "usuarios");
$empate1 = doquery("UPDATE {{table}} SET pvpempatados=pvpempatados+1 WHERE id=".$row["desafiador"], "usuarios");
$enviomensaje = doquery("INSERT INTO {{table}} SET Remitente='Comite de lucha', Destinatario='".$row["desafiador"]."', message='El comite de lucha ha decidido que tu batalla contra ".$userrow["charname"]." ha dado como resultado empate. Este es un mensaje automatico, no responder.', title='Combate', Date=NOW()", "mail");
$query4 = doquery("DELETE FROM {{table}} WHERE id='$id'", "pvp");
}


elseif($row["nivelpvp"] < $userrow["nivelpvp"]) //Gana el que acepta el desafio
 { $page.= "<div class='contenido2'>";
 $page.= "<table><tr><td>".$userrow["charname"]."</td><td>Versus</td><td>".$row["charname"]."</td></tr><tr><td>".$userrow["nivel"]."</td><td>Nivel</td><td>".$desafiadorrow["nivel"]."</td></tr><tr><td>".$userrow["strength"]."</td><td>Fuerza</td><td>".$desafiadorrow["strength"]."</td></tr><tr><td>".$userrow["dexterity"]."</td><td>Agilidad</td><td>".$desafiadorrow["dexterity"]."</td></tr><tr><td>".$userrow["attackpower"]."</td><td>Poder de<br />Ataque</td><td>".$desafiadorrow["attackpower"]."</td></tr><tr><td>".$userrow["defensepower"]."</td><td>Poder de<br />Defensa</td><td>".$desafiadorrow["defensepower"]."</td></tr><tr><td>".$userrow["currenthp"]."</td><td>Vida<br />Actual</td><td>".$desafiadorrow["currenthp"]."</td></tr><tr><td>".$userrow["currentmp"]."</td><td>Mana<br />Actual</td><td>".$desafiadorrow["currentmp"]."</td></tr><tr><td>".$userrow["nivelpvp"]."</td><td>Resultado de<br />la Batalla</td><td>".$row["nivelpvp"]."</td></tr><br />Has ganado!</table><form action=index.php?do=arena method=post><input type=submit value='Volver a la Arena de Combate' name=ganar></div>";
 
 $query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "pvp");
$row = mysql_fetch_array($query);
$apuesta = $row["apuesta"];
$oponente = $row["oponente"];
$query2= doquery("SELECT gold FROM {{table}} WHERE id='$oponente'", "usuarios");
$qrow = mysql_fetch_array($query2);
$apuesta2 = $qrow["gold"];
$newgold = $apuesta2 + $apuesta;
$query3 = doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='$oponente' LIMIT 1", "usuarios");
$perdedor = doquery("UPDATE {{table}} SET pvpganados=pvpganados+1 WHERE id=".$userrow["id"], "usuarios");
$ganador = doquery("UPDATE {{table}} SET pvpperdidos=pvpperdidos+1 WHERE id=".$row["desafiador"], "usuarios");
$enviomensaje = doquery("INSERT INTO {{table}} SET Remitente='Comite de lucha', Destinatario='".$row["desafiador"]."', message='El comite de lucha ha decidido que has perdido contra ".$userrow["charname"].". Este es un mensaje automatico, no responder.', title='Combate', Date=NOW()", "mail");
$query4 = doquery("DELETE FROM {{table}} WHERE id='$id'", "pvp");
}

else { $page.="Error"; }
display($page, "Desafio"); 
}

 function pvp3($id) { //Cancelar el pvp y devuelve el oro al desafiador
    	
		global $userrow, $numqueries;

$query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "pvp");
$row = mysql_fetch_array($query);
$apuesta = $row["apuesta"];
$desafiador = $row["desafiador"];
$query2= doquery("SELECT gold FROM {{table}} WHERE id='$desafiador'", "usuarios");
$qrow = mysql_fetch_array($query2);
$apuesta2 = $qrow["gold"];
$newgold = $apuesta2 + $apuesta;
$query3 = doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='$desafiador' LIMIT 1", "usuarios");
$enviomensaje = doquery("INSERT INTO {{table}} SET Remitente='Comite de lucha', Destinatario='".$row["desafiador"]."', message='".$userrow["charname"]." Ha cancelado el desafio. Este es un mensaje automatico, no responder.', title='Combate', Date=NOW()", "mail");
$queryfinal = doquery("DELETE FROM {{table}} WHERE id='$id'  LIMIT 1", "pvp"); //Elimina el pvp


 
$page .= "<strong><div class='contenido2'>Desafio Cancelado</strong>";
$page .= "<p><a href=\"index.php?do=desafios\">Volver a Desafios Pendientes</a>.</div>";

display($page, "Cancelar desafio");
}

function pvp4($id) { //Cancelar el pvp el desafiador y le devuelve parte del oro
    	
		global $userrow, $numqueries;

$query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "pvp");
$row = mysql_fetch_array($query);
$apuesta = $row["apuesta"] * 0.95; //Aqui sacamos el porcentaje que le quita al desafiador por cancelar el pvp
$desafiador = $row["desafiador"];
$query2= doquery("SELECT gold FROM {{table}} WHERE id='$desafiador'", "usuarios");
$qrow = mysql_fetch_array($query2);
$apuesta2 = $qrow["gold"];
$newgold = $apuesta2 + $apuesta;
$query3 = doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='$desafiador' LIMIT 1", "usuarios");
$queryfinal = doquery("DELETE FROM {{table}} WHERE id='$id'  LIMIT 1", "pvp"); //Elimina el pvp

 
$page .= "<strong><div class='contenido2'>Has cancelado un desafio, como consecuencia perdiste el 5% de la apuesta.</strong>";
$page .= "<p><a href=\"index.php?do=desafiados\">Volver a Desafios Enviados</a>.</div>";

display($page, "Cancelar desafio");
}

function menu() { //Menu de Arena
global $userrow;
$nivelpvp = $userrow["strength"] + $userrow["dexterity"] + $userrow["attackpower"] + $userrow["defensepower"] + $userrow["currenthp"] + $userrow["currentmp"]; 
$update = doquery("UPDATE {{table}} SET nivelpvp='$nivelpvp' WHERE id='".$userrow["id"]."' LIMIT 1","usuarios");
$page = "<div class='titulo'>Arena de Combate</div>
		<div class='contenido2'><img src=\"estilo/imagenes/arena/arena.png\"><br /><br /><a href=\"index.php?do=desafiar\"><img border=0 src=\"estilo/imagenes/arena/desafiar.png\" ></A><a href=\"index.php?do=desafios\"><img border=0 src=\"estilo/imagenes/arena/ver.png\" ></A><a href=\"index.php?do=desafiados\"><img border=0 src=\"estilo/imagenes/arena/enviados.png\" ></A><a href=\"index.php?do=entrenar\"><img border=0 src=\"estilo/imagenes/arena/entrenar.png\" ></A><br /><br /><a href=\"index.php\">Volver a la ciudad</a></div>";
display($page, "Arena de Combate"); }

?>

