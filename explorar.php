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
function move() {
    
    global $userrow, $controlrow;
    
    if ($userrow["currentaction"] == "Peleando") { header("Location: index.php?do=pelear"); die(); }
    
    $latitude = $userrow["latitude"];
    $longitude = $userrow["longitude"];
    if (isset($_POST["north_x"])) { $latitude++; if ($latitude > $controlrow["gamesize"]) { $latitude = $controlrow["gamesize"]; } }
if (isset($_POST["west_x"])) { $longitude--; if ($longitude < ($controlrow["gamesize"]*-1)) { $longitude = ($controlrow["gamesize"]*-1); } }
if (isset($_POST["east_x"])) { $longitude++; if ($longitude > $controlrow["gamesize"]) { $longitude = $controlrow["gamesize"]; } }
if (isset($_POST["south_x"])) { $latitude--; if ($latitude < ($controlrow["gamesize"]*-1)) { $latitude = ($controlrow["gamesize"]*-1); } }
    
    $townquery = doquery("SELECT id FROM {{table}} WHERE latitude='$latitude' AND longitude='$longitude' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) > 0) {
        $townrow = mysql_fetch_array($townquery);
        include('ciudad.php');
        travelto($townrow["id"], false);
        die();
    }
    //Encontrar monstruos explorando
    $chancetofight = rand(1,5);
    if ($chancetofight == 1) { 
        $action = "currentaction='Peleando', currentfight='1',";
    } else {
        $action = "currentaction='Explorando',";
    }
	//Encontrar oro explorando
	$encuentraoro = rand(1,200); // Probabilidades de encontrar oro
if ($encuentraoro == 1) { 
	$gold = rand(1,50); // Cantidad de oro aleatorio que puede encontrar un jugador
	doquery("UPDATE {{table}} SET gold=gold+$gold WHERE id=".$userrow["id"], "usuarios"); 
	doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios"); 
	$page = "<div class='contenido2'>Has encontrado $gold de oro escondido entre los arboles!<br /><br /><img border=0 src=\"estilo/imagenes/exploracion/oro.png\" ></div>"; 
	display($page, "Has encontrado oro!");
	die();
}
	//Encontrar campamento
	$campamento = rand(1,1000); // Probabilidades de encontrar campamento
if ($campamento == 1) { 
	doquery("UPDATE {{table}} SET currenthp='".$userrow["maxhp"]."', currentmp='".$userrow["maxmp"]."', currenttp='".$userrow["maxtp"]."' WHERE id=".$userrow["id"], "usuarios"); 
	doquery("UPDATE {{table}} SET latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios"); 
	$page = "<div class='contenido2'>Has encontrado un campamento, descansas y consigues restaurar todos los puntos de tu Heroe<br /><br /><img border=0 src=\"estilo/imagenes/exploracion/campamento.png\" ></div>"; 
	display($page, "Has encontrado un campamento!");
	die();
}

    
    $updatequery = doquery("UPDATE {{table}} SET $action latitude='$latitude', longitude='$longitude', dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
    header("Location: index.php");
    
}

?>