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
function inn() { //Posada.
    
    global $userrow, $numqueries;

    $townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) != 1) { display("Se ha detectado el uso de Cheats.", "Error"); }
    $townrow = mysql_fetch_array($townquery);
    
    if ($userrow["gold"] < $townrow["innprice"]) { display("<div class='contenido2'>No tienes oro suficiente para quedarte en la Posada.<br /><br />Resegra a la <a href=\"index.php\">ciudad</a> o comienza una aventura para conseguir oro.</div>", "Hotel"); die(); }
    
    if (isset($_POST["submit"])) {
        
        $newgold = $userrow["gold"] - $townrow["innprice"];
        $query = doquery("UPDATE {{table}} SET gold='$newgold',currenthp='".$userrow["maxhp"]."',currentmp='".$userrow["maxmp"]."',currenttp='".$userrow["maxtp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
        $title = "Hotel";
        $page = "<div class='contenido2'><p>Te despiertas y te sientes refrescante y listo para una nueva aventura.</p>
		<p>Puedes regresar a la <a href=\"index.php\">ciudad</a>, o empezar a explorar con los botones de navegación.</p></div>>";
        
    } elseif (isset($_POST["cancel"])) {
        
        header("Location: index.php"); die();
         
    } else {
        
        $title = "Posada";
		$page = "<div class='titulo'>Bienvenido a la posada</div>
				  <div class='contenido2'>
				  <div class='posada'></div>
				  <div class='posada2'>
				  <p>Aqu&iacute; puedes recuperar tus PV; PM Y PR</p>
				  <p> Te costar&aacute; ". $townrow["innprice"] ." monedas de oro.</p>  
				  <p align=center>&iquest;Quieres dormir aqu&iacute;?</p>
				  <form action=\"index.php?do=hotel\" method=\"post\">
				  <p align=center><input type=\"submit\" name=\"submit\" value=\"Sí\" /> 
				  <input type=\"submit\" name=\"cancel\" value=\"No\" /></p>
				  </form></div></div>";
        
    }
    
    display($page, $title);
    
}

function buy() { // Variables para compra.
    
    global $userrow, $numqueries;
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) != 1) { display("<div class='contenido2'>Se ha detectado el uso de Cheats.</div>", "Error"); }
    $townrow = mysql_fetch_array($townquery);
    
    $itemslist = explode(",",$townrow["itemslist"]);
    $querystring = "";
    foreach($itemslist as $a=>$b) {
        $querystring .= "id='$b' OR ";
    }
    $querystring = rtrim($querystring, " OR ");
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE $querystring ORDER BY id", "items");
    $page = "<div class='titulo'>Tienda de Armas</div><div class='contenido2'>Los siguientes items est&aacute;n disponibles en esta ciudad:<br /><br />\n";
	$page .= "<span class='tipo'>Tipo</span><span class='nombre'>Nombre</span><span class='item3'>Atributo</span><span class='item4'>Precio</span><span class='item5'></span><ul class='nopun'>";
    while ($itemsrow = mysql_fetch_array($itemsquery)) {
		$page .= "<li>";
        if ($itemsrow["type"] == 1) { $attrib = "Poder de Ataque:"; } else  { $attrib = "Poder de Defensa:"; }
        if ($itemsrow["type"] == 1) { $page .= "<span class='item'><img src=\"estilo/imagenes/iconos/icono_arma.gif\" alt=\"Arma\" /></span>"; }
        if ($itemsrow["type"] == 2) { $page .= "<span class='item'><img src=\"estilo/imagenes/iconos/icono_armadura.gif\" alt=\"Armadura\" /></span>"; }
        if ($itemsrow["type"] == 3) { $page .= "<span class='item'><img src=\"estilo/imagenes/iconos/icono_escudo.gif\" alt=\"Escudo\" /></span>"; }
        if ($userrow["weaponid"] == $itemsrow["id"] || $userrow["armorid"] == $itemsrow["id"] || $userrow["shieldid"] == $itemsrow["id"]) {
            $page .= "<span class='item2'>".$itemsrow["name"]."</span><span class='item3'>$attrib ".$itemsrow["attribute"]."</span><span class='item4'>Precio:".$itemsrow["buycost"]." PO</span><span class='item5'>Ya comprado</span></li>";
        } else {
            if ($itemsrow["special"] != "X") { $specialdot = "<span class=\"highlight\">&#42;</span>"; } else { $specialdot = ""; }
            $page .= "<span class='item2'>".$itemsrow["name"]."</span><span class='item3'>$specialdot $attrib ".$itemsrow["attribute"]."</span><span class='item4'>Precio: ".$itemsrow["buycost"]."PO</span><span class='item5'><a href=\"index.php?do=comprar2:".$itemsrow["id"]."\">Comprar</a></span></li>";
        }
    }
    $page .= "</ul><br>Si no deseas comprar nada o ya has comprado lo suficiente puedes regresar a la <a href=\"index.php\">ciudad</a></div>";
    $title = "Comprar Items";
    
    display($page, $title);
    
}

function buy2($id) { // Confirmar usuario.
    
    global $userrow, $numqueries;
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) != 1) { display("<div class='contenido2'>Se ha detectado el uso de Cheats.</div>", "Error"); }
    $townrow = mysql_fetch_array($townquery);
    $townitems = explode(",",$townrow["itemslist"]);
    if (! in_array($id, $townitems)) { display("Se ha detectado el uso de Cheats.", "Error"); }
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items");
    $itemsrow = mysql_fetch_array($itemsquery);
    
    if ($userrow["gold"] < $itemsrow["buycost"]) { display("<div class='titulo'>No tienes suficientes oro</div><div class='contenido2'>No tienes suficiente oro para comprar este item.<br /><br /><a href=\"index.php\">Regresar a la Ciudad</a><br /><a href=\"index.php?do=comprar\">Regresar al Comercio</a><br /> Usa los botones de movimiento para empezar a explorar.</div>", "Comprar Items"); die(); }
    
    if ($itemsrow["type"] == 1) {
        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
            $page = "<div class='titulo'>Compra</div><div class='contenido2'>¿ Quieres comprar ".$itemsrow["name"]." ?. Entregame tu ".$itemsrow2["name"]." por ".ceil($itemsrow2["buycost"]/2)." Piezas de Oro. ¿ Quieres ?<br /><br /><form action=\"index.php?do=comprar3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
        } else {
            $page = "<div class='titulo'>Compra</div><div class='contenido2'>¿ Quieres comprar ".$itemsrow["name"]." ?<br /><br /><form action=\"index.php?do=comprar3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
        }
    } elseif ($itemsrow["type"] == 2) {
        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
            $page = "<div class='titulo'>Compra</div><div class='contenido2'>¿ Quieres comprar ".$itemsrow["name"]." ?. Entregame tu ".$itemsrow2["name"]." por ".ceil($itemsrow2["buycost"]/2)." Piezas de Oro. ¿ Quieres ?<br /><br /><form action=\"index.php?do=comprar3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
        } else {
            $page = "<div class='titulo'>compraNo tienes suficiente oro</div><div class='contenido2'>¿ Quieres comprar ".$itemsrow["name"]." ?<br /><br /><form action=\"index.php?do=comprar3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
        }
    } elseif ($itemsrow["type"] == 3) {
        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
            $page = "<div class='titulo'>Compra</div><div class='contenido2'>¿ Quieres comprar ".$itemsrow["name"]." ?. Entregame tu ".$itemsrow2["name"]." por ".ceil($itemsrow2["buycost"]/2)." Piezas de Oro. ¿ Quieres ?<br /><br /><form action=\"index.php?do=comprar3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
        } else {
            $page = "<div class='titulo'>Compra</div><div class='contenido2'>¿ Quieres comprar ".$itemsrow["name"]." ?<br /><br /><form action=\"index.php?do=comprar3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
        }
    }
    
    $title = "Comprar Items";
    display($page, $title);
   
}

function buy3($id) { // Actualizar items.
    
    if (isset($_POST["cancel"])) { header("Location: index.php"); die(); }
    
    global $userrow;
    
    $townquery = doquery("SELECT name,itemslist FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
    if (mysql_num_rows($townquery) != 1) { display("<div class='contenido2'>Se ha detectado el uso de chetos.</div>", "Error"); }
    $townrow = mysql_fetch_array($townquery);
    $townitems = explode(",",$townrow["itemslist"]);
    if (! in_array($id, $townitems)) { display("<div class='contenido2'>Se ha detecado el uso de chetos.</div>", "Error"); }
    
    $itemsquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "items");
    $itemsrow = mysql_fetch_array($itemsquery);
    
    if ($userrow["gold"] < $itemsrow["buycost"]) { display("<div class='titulo'>No tienes suficiente oro</div><div class='contenido2'><a href=\"index.php\">Regresar a la Ciudad</a><br /><a href=\"index.php?do=comprar\">Regresar al Comercio</a><br /> Usa los botones de movimiento para empezar a explorar.</div>", "Comprar Items"); die(); }
    
    if ($itemsrow["type"] == 1) { // arma
    	
    	// Ver si tiene el item
        if ($userrow["weaponid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["weaponid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
        } else {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"X");
        }
        
        // Items especiales
        $specialchange1 = "";
        $specialchange2 = "";
        if ($itemsrow["special"] != "X") {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $userrow[$tochange] = $userrow[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$userrow[$tochange]."',";
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; }
        }
        if ($itemsrow2["special"] != "X") {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',";
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; }
        }
        
        // Nuevas estadisticas
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"];
        $newattack = $userrow["attackpower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
        $newid = $itemsrow["id"];
        $newname = $itemsrow["name"];
        $userid = $userrow["id"];
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; }
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; }
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; }
        
        // Actualización final.
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', attackpower='$newattack', weaponid='$newid', weaponname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "usuarios");
        
    } elseif ($itemsrow["type"] == 2) { // Armadura

    	// Ver si tiene un item en el espacio.
        if ($userrow["armorid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["armorid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
        } else {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"X");
        }
        
        // Items especiales.
        $specialchange1 = "";
        $specialchange2 = "";
        if ($itemsrow["special"] != "X") {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $userrow[$tochange] = $userrow[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$userrow[$tochange]."',";
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; }
        }
        if ($itemsrow2["special"] != "X") {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',";
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; }
        }
        
        // Nuevas estadisticas.
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"];
        $newdefense = $userrow["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
        $newid = $itemsrow["id"];
        $newname = $itemsrow["name"];
        $userid = $userrow["id"];
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; }
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; }
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; }
        
        // Actualziacion final.
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', armorid='$newid', armorname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "usuarios");

    } elseif ($itemsrow["type"] == 3) { // Escudo

    	// Ver si tiene un slot.
        if ($userrow["shieldid"] != 0) { 
            $itemsquery2 = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["shieldid"]."' LIMIT 1", "items");
            $itemsrow2 = mysql_fetch_array($itemsquery2);
        } else {
            $itemsrow2 = array("attribute"=>0,"buycost"=>0,"special"=>"X");
        }
        
        // item especial.
        $specialchange1 = "";
        $specialchange2 = "";
        if ($itemsrow["special"] != "X") {
            $special = explode(",",$itemsrow["special"]);
            $tochange = $special[0];
            $userrow[$tochange] = $userrow[$tochange] + $special[1];
            $specialchange1 = "$tochange='".$userrow[$tochange]."',";
            if ($tochange == "strength") { $userrow["attackpower"] += $special[1]; }
            if ($tochange == "dexterity") { $userrow["defensepower"] += $special[1]; }
        }
        if ($itemsrow2["special"] != "X") {
            $special2 = explode(",",$itemsrow2["special"]);
            $tochange2 = $special2[0];
            $userrow[$tochange2] = $userrow[$tochange2] - $special2[1];
            $specialchange2 = "$tochange2='".$userrow[$tochange2]."',";
            if ($tochange2 == "strength") { $userrow["attackpower"] -= $special2[1]; }
            if ($tochange2 == "dexterity") { $userrow["defensepower"] -= $special2[1]; }
        }
        
        // Nueva estadistica.
        $newgold = $userrow["gold"] + ceil($itemsrow2["buycost"]/2) - $itemsrow["buycost"];
        $newdefense = $userrow["defensepower"] + $itemsrow["attribute"] - $itemsrow2["attribute"];
        $newid = $itemsrow["id"];
        $newname = $itemsrow["name"];
        $userid = $userrow["id"];
        if ($userrow["currenthp"] > $userrow["maxhp"]) { $newhp = $userrow["maxhp"]; } else { $newhp = $userrow["currenthp"]; }
        if ($userrow["currentmp"] > $userrow["maxmp"]) { $newmp = $userrow["maxmp"]; } else { $newmp = $userrow["currentmp"]; }
        if ($userrow["currenttp"] > $userrow["maxtp"]) { $newtp = $userrow["maxtp"]; } else { $newtp = $userrow["currenttp"]; }
        
        // Actualizacion final.
        $updatequery = doquery("UPDATE {{table}} SET $specialchange1 $specialchange2 gold='$newgold', defensepower='$newdefense', shieldid='$newid', shieldname='$newname', currenthp='$newhp', currentmp='$newmp', currenttp='$newtp' WHERE id='$userid' LIMIT 1", "usuarios");        
    
    }
    
    display("<div class='titulo'>Item comprado</div><div class='contenido2'>Gracias por su compra, valiente ".$userrow["charname"].".<br /><a href=\"index.php\">Regresar a la Ciudad</a><br /><a href=\"index.php?do=comprar\">Regresar al Comercio</a><br /> Usa los botones de movimiento para empezar a explorar.</div>", "Comprar Items");

}

function maps() { // Tienda de mapas
    
    global $userrow, $numqueries;
    
    $mappedtowns = explode(",",$userrow["towns"]);
    
    $page = "<div class='titulo'>Tienda de Mapas</div><div class='contenido2'><img border=0 src=\"estilo/imagenes/default/mapa.png\" ><br /><br />Si compras mapas podrás viajar más rápido a las diferentes ciudades..<br /><br />\n";
    $page .= "Compra los diferentes mapas disponibles en esta ciudad para despues viajar, pero ten cuidado con los bichos que acechan en otras ciudades.<br /><br />\n";
    $page .= "<span class='tipo'>Nombre del mapa</span><span class='mapas2'>Ubicaci&oacute;n</span><span class='mapas3'>Precio</span><span class='mapas4'></span><ul class='nopun'>";
    
    $townquery = doquery("SELECT * FROM {{table}} ORDER BY id", "ciudades");
    while ($townrow = mysql_fetch_array($townquery)) {
        $page .= "<li>";
        if ($townrow["latitude"] >= 0) { $latitude = $townrow["latitude"] . "N,"; } else { $latitude = ($townrow["latitude"]*-1) . "S,"; }
        if ($townrow["longitude"] >= 0) { $longitude = $townrow["longitude"] . "E"; } else { $longitude = ($townrow["longitude"]*-1) . "O"; }
        
        $mapped = false;
        foreach($mappedtowns as $a => $b) {
            if ($b == $townrow["id"]) { $mapped = true; }
        }
        if ($mapped == false) {
            $page .= "<span class='mapas'>".$townrow["name"]."</span><span class='mapas2'>Compralo para desvelarlo</span><span class='mapas3'>Precio: ".$townrow["mapprice"]." Oro</span><span class='mapas4'><a href=\"index.php?do=mapas2:".$townrow["id"]."\">Comprar</a></span></li>";
        } else {
            $page .= "<span class='mapas'>".$townrow["name"]."</span><span class='mapas2'>Ubicación: $latitude $longitude PR: ".$townrow["travelpoints"]."</span><span class='mapas3'>Precio: ".$townrow["mapprice"]." Oro</span><span class='mapas4'>Ya comprado</span></li>";
        }
        
    }
    
    $page .= "</ul><br />\n";
    $page .= "Si has cambiado de idea puedes regresar a la <a href=\"index.php\">ciudad</a></div>";
    
    display($page, "Comprar Mapas");
    
}

function maps2($id) { // Confirmacion.
    
    global $userrow, $numqueries;
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "ciudades");
    $townrow = mysql_fetch_array($townquery);
    
    if ($userrow["gold"] < $townrow["mapprice"]) { display("<div class='titulo'>No tienes suficiente oro</div><div class='contenido2'><a href=\"index.php\">Regresar a la Ciudad</a><br /><a href=\"index.php?do=mapas\">Regresar al Comercio</a><br /> Usa los botones de movimiento para empezar a explorar.</div>", "Comprar Mapas"); die(); }
    
    $page = "<div class='titulo'>Compra</div><div class='contenido2'>¿ Quieres comprar el mapa de ".$townrow["name"]." ?<br /><br /><form action=\"index.php?do=mapas3:$id\" method=\"post\"><input type=\"submit\" name=\"submit\" value=\"Sí\" /> <input type=\"submit\" name=\"cancel\" value=\"No\" /></form></div>";
    
    display($page, "Comprar Mapas");
    
}

function maps3($id) { // Agregar mapa.
    
    if (isset($_POST["cancel"])) { header("Location: index.php"); die(); }
    
    global $userrow, $numqueries;
    
    $townquery = doquery("SELECT name,mapprice FROM {{table}} WHERE id='$id' LIMIT 1", "ciudades");
    $townrow = mysql_fetch_array($townquery);
    
    if ($userrow["gold"] < $townrow["mapprice"]) { display("<div class='titulo'>No tienes suficiente oro</div><div class='contenido2'><br /><br /><a href=\"index.php\">Regresar a la Ciudad</a><br /><a href=\"index.php?do=mapas\">Regresar al Comercio</a><br /> Usa los botones de movimiento para empezar a explorar.</div>", "Comprar Mapas"); die(); }
    
    $mappedtowns = $userrow["towns"].",$id";
    $newgold = $userrow["gold"] - $townrow["mapprice"];
    
    $updatequery = doquery("UPDATE {{table}} SET towns='$mappedtowns',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
    
    display("<div class='titulo'>Mapa comprado</div><div class='contenido2'>Gracias por su compra, valiente ".$userrow["charname"].".<br /><a href=\"index.php\">Regresar a la Ciudad</a><br /><a href=\"index.php?do=mapas\">Regresar al Comercio</a><br /> Usa los botones de movimiento para empezar a explorar.</div>", "Comprar Mapas");
    
}

function travelto($id, $usepoints=true) { // Enviar a usuario al menu de mapas.
    
    global $userrow, $numqueries;
    
    if ($userrow["currentaction"] == "Peleando") { header("Location: index.php?do=pelear"); die(); }
    
    $townquery = doquery("SELECT name,travelpoints,latitude,longitude FROM {{table}} WHERE id='$id' LIMIT 1", "ciudades");
    $townrow = mysql_fetch_array($townquery);
    
    if ($usepoints==true) { 
        if ($userrow["currenttp"] < $townrow["travelpoints"]) { 
            display("<div class='contenido2'>No tienes Puntos de Recorrido (PR) para viajar.</div>", "Viajar a: ".$townrow["name"].""); die(); 
        }
        $mapped = explode(",",$userrow["towns"]);
        if (!in_array($id, $mapped)) { display("<div class='contenido2'>Se ha detectado el uso de Cheats.</div>", "Error"); }
    }
    
    if (($userrow["latitude"] == $townrow["latitude"]) && ($userrow["longitude"] == $townrow["longitude"])) { display("<div class='contenido2'>Actualmente estas en esta ciudad. <a href=\"index.php\">Volver a la ciudad</a>.</div>", "Viajar a: ".$townrow["name"].""); die(); }
    
    if ($usepoints == true) { $newtp = $userrow["currenttp"] - $townrow["travelpoints"]; } else { $newtp = $userrow["currenttp"]; }
    
    $newlat = $townrow["latitude"];
    $newlon = $townrow["longitude"];
    $newid = $userrow["id"];
    
    // Si esta explorando agregar ciudad.
    $mapped = explode(",",$userrow["towns"]);
    $town = false;
    foreach($mapped as $a => $b) {
        if ($b == $id) { $town = true; }
    }
    $mapped = implode(",",$mapped);
    if ($town == false) { 
        $mapped .= ",$id";
        $mapped = "towns='".$mapped."',";
    } else { 
        $mapped = "towns='".$mapped."',";
    }
    
    $updatequery = doquery("UPDATE {{table}} SET currentaction='En la ciudad',$mapped currenttp='$newtp',latitude='$newlat',longitude='$newlon' WHERE id='$newid' LIMIT 1", "usuarios");
    
    $page = "<div class='titulo'>Viajaste a ".$townrow["name"].".</div><div class='contenido2'>Ahora puedes <a href=\"index.php\">entrar a la ciudad</a>.</div>";
    display($page, "Viajar a: ".$townrow["name"]."");
    
}

// Ranking de jugadores
function topten($value=0) { 

    global $userrow;
	$start=$value;
	
    $page = "<div class='titulo'>Ranking</div><div class='contenido2'>Aquí podrás ver la clasificaci&oacute;n de usuarios. Haz click en un personaje para ver sus estadisticas.\n<br /><br />\n";
    $page .= "<table width=\"80%\"><tr><td width=\"10%\"><b>Posicion</b></td><td width=\"50\">Nombre del usuario</a></td><td width=\"20%\">Nivel</td><td width=\"20%\">Experiencia</td><td width=\"20%\">Clan</td></tr>";
	$usuariostotal = doquery("SELECT * FROM {{table}}", "usuarios");
	$limInf=$start*20;
    $topquery = doquery("SELECT * FROM {{table}} ORDER BY experience DESC LIMIT $limInf,20", "usuarios");
     $rank = $limInf+1;
    while ($toprow = mysql_fetch_array($topquery)) { 
        $page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\"><a href=\"index.php?do=enlinea:".$toprow["id"]."\">".$toprow["charname"]."</a></td><td width=\"20%\">Nivel: <b>".$toprow["nivel"]."</b></td><td width=\"20%\">Exp: <b>".number_format($toprow["experience"])."</b></td><td width=\"20%\"><b>".$toprow["nombreclan"]."</b></td></tr>\n";
        $rank++;
    }
    $page .= "</table>\n<br /><br />\n";
	$page .= "<tr><td colspan='6' style='background-color:#000000;'><center> Paginas [ ";
   	$numpages = intval (mysql_num_rows($usuariostotal)/20);
	for($pagenum = 0; $pagenum <= $numpages; $pagenum++) {
	if ($start != $pagenum) {
		$page .= "<a href='index.php?do=rank:".$pagenum."'>".($pagenum+1)."</a>   ";
	}else {
		$page .= "<i>".($pagenum+1)."</i>   ";
	}
	}
	$page .= " ]</center></td></tr>";
    $page .= "<a href=\"index.php\">Volver a la ciudad</a> - <a href=\"index.php?do=rankpvp\">Ver el Ranking PvP</a></div>";
    display($page, "Ranking de Usuarios");
	
	
}

// Ranking de pvp
function toppvp($value=0) { 

    global $userrow;
	$start=$value;
	
    $page = "<div class='titulo'>Ranking PvP</div><div class='contenido2'>Aquí podrás ver la clasificaci&oacute;n de la Arena (PvP). Haz click en un personaje para ver sus estadisticas.\n<br /><br />\n";
    $page .= "<table width=\"80%\"><tr><td width=\"10%\"><b>Posicion</b></td><td width=\"50\">Nombre del usuario</a></td><td width=\"20%\">PvP-Ganados</td><td width=\"20%\">PvP-Empatados</td><td width=\"20%\">PvP-Perdidos</td></tr>";
	$usuariostotal = doquery("SELECT * FROM {{table}}", "usuarios");
	$limInf=$start*20;
    $topquery = doquery("SELECT * FROM {{table}} ORDER BY pvpganados DESC LIMIT $limInf,20", "usuarios");
     $rank = $limInf+1;
    while ($toprow = mysql_fetch_array($topquery)) { 
        $page .= "<tr><td width=\"10%\"><b>$rank</b></td><td width=\"50\"><a href=\"index.php?do=enlinea:".$toprow["id"]."\">".$toprow["charname"]."</a></td><td width=\"20%\"><b>".$toprow["pvpganados"]."</b></td><td width=\"20%\"><b>".$toprow["pvpempatados"]."</b></td><td width=\"20%\"><b>".$toprow["pvpperdidos"]."</b></td></tr>\n";
        $rank++;
    }
    $page .= "</table>\n<br /><br />\n";
	$page .= "<tr><td colspan='6' style='background-color:#000000;'><center> Paginas [ ";
   	$numpages = intval (mysql_num_rows($usuariostotal)/20);
	for($pagenum = 0; $pagenum <= $numpages; $pagenum++) {
	if ($start != $pagenum) {
		$page .= "<a href='index.php?do=rankpvp:".$pagenum."'>".($pagenum+1)."</a>   ";
	}else {
		$page .= "<i>".($pagenum+1)."</i>   ";
	}
	}
	$page .= " ]</center></td></tr>";
    $page .= "<a href=\"index.php\">Volver a la ciudad</a> - <a href=\"index.php?do=rank\">Ver el Ranking General</a></div>";
    display($page, "Ranking de PvP");
	
	
}

 //Chat bablebox
function chat() { 
    
    global $userrow, $controlrow;
 if ($controlrow["showbabble"] == 1) {
$query = doquery("UPDATE {{table}} SET chattime=NOW() WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");


    if ($userrow["nivel"] < 1) { //Aqui podemos elegir el nivel necesario para usar el chat
die("Debes tener nivel 1 para usar el chat."); }

    elseif ($userrow["autorizacion"] == 4) {
die("Has sido baneado por un moderador y no puedes usar el chat.Para m&aacute;s informaci&oacute;n contacta con la Administraci&oacute;n."); }

    if (isset($_POST["mensaje"])) {
        $safecontent = makesafe($_POST["mensaje"]);	
		

        if ($safecontent == "" || $safecontent == " ") { //Post en blanco si no quieres nada
        } else { 
            if (substr($safecontent,0,2) == "/m") {
                $msgarray = explode(" ",$safecontent);
                unset($msgarray[0]);
                $to = $msgarray[1];
                unset($msgarray[1]);
                $safecontent = implode(" ",$msgarray);
            } else { $to = ""; }
            $insert = doquery("INSERT INTO {{table}} SET id='', fh_mensaje=NOW(),usuario='".$userrow["charname"]."',mensaje='$safecontent',touser='$to'", "chat"); 
        }
        header("Location: index.php?do=chat");
        die();
    }
    
    $babblebox = array("content"=>"");
    $bg = 1;
	$babblebox["content"] .= "<div class='titulo'>Chat</div>";
    $babblequery = doquery("SELECT * FROM {{table}} WHERE touser='' OR touser='".$userrow["charname"]."' OR usuario='".$userrow["charname"]."' ORDER BY id DESC LIMIT 20", "chat");
    while ($babblerow = mysql_fetch_array($babblequery)) {
			    $babblerow = str_replace(":)", "<img src='estilo/imagenes/emoticonos/smiley.gif'>", $babblerow); 
				$babblerow = str_replace(":D", "<img src='estilo/imagenes/emoticonos/cheese.gif'>", $babblerow);
				$babblerow = str_replace(";D", "<img src='estilo/imagenes/emoticonos/grin.gif'>", $babblerow);
			    $babblerow = str_replace(":(", "<img src='estilo/imagenes/emoticonos/sad.gif'>", $babblerow);
				$babblerow = str_replace(">:(", "<img src='estilo/imagenes/emoticonos/angry.gif'>", $babblerow);
				$babblerow = str_replace(":o", "<img src='estilo/imagenes/emoticonos/shocked.gif'>", $babblerow);
				$babblerow = str_replace("8)", "<img src='estilo/imagenes/emoticonos/cool.gif'>", $babblerow);
				$babblerow = str_replace("???", "<img src='estilo/imagenes/emoticonos/huh.gif'>", $babblerow);
				$babblerow = str_replace("::)", "<img src='estilo/imagenes/emoticonos/rolleyes.gif'>", $babblerow);
		        $babblerow = str_replace(":P", "<img src='estilo/imagenes/emoticonos/tongue.gif'>", $babblerow);
			    $babblerow = str_replace(";)", "<img src='estilo/imagenes/emoticonos/wink.gif'>", $babblerow);
			    $babblerow = str_replace("^^", "<img src='estilo/imagenes/emoticonos/rolleyes.gif'>", $babblerow);
			    $babblerow = str_replace(":$", "<img src='estilo/imagenes/emoticonos/embaressed.gif'>", $babblerow);
			    $babblerow = str_replace(":-X", "<img src='estilo/imagenes/emoticonos/lipsrsealed.gif'>", $babblerow);
				$babblerow = str_replace(":-|", "<img src='estilo/imagenes/emoticonos/undecided.gif'>", $babblerow);
				$babblerow = str_replace(":-*", "<img src='estilo/imagenes/emoticonos/kiss.gif'>", $babblerow);
				$babblerow = str_replace(":'(", "<img src='estilo/imagenes/emoticonos/cry.gif'>", $babblerow);
			    $babblerow = str_replace("joder", " <b><font color=red>******</font></b> ", $babblerow); 
			    $babblerow = str_replace("shit", " <b><font color=red>[Word Censored]</font></b> ", $babblerow);
			    $babblerow = str_replace("bastard", " <b><font color=red>[Word Censored]</font></b> ", $babblerow); 
			    $babblerow = str_replace("piss", " <b><font color=red>[Word Censored]</font></b> ", $babblerow); 
			    $babblerow = str_replace("cunt", " <b><font color=red>[Word Censored]</font></b> ", $babblerow); 		
			    $babblerow = str_replace("dick", " <b><font color=red>[Word Censored]</font></b> ", $babblerow); 			    $babblerow = str_replace("bitch", " <b><font color=red>[Word Censored]</font></b> ", $babblerow); 	
			    $babblerow = str_replace("twat", " <b><font color=red>[Word Censored]</font></b> ", $babblerow); 
		 	
       $cu = doquery("SELECT autorizacion FROM {{table}} WHERE charname='".$babblerow["usuario"]."' LIMIT 1", "usuarios");
			$chatrow = mysql_fetch_array($cu);
      //Se encarga del color de los nicks segun el nivel de autorización
            if ($chatrow["autorizacion"] == 0) {
	    $name = "<font color=black>".$babblerow["usuario"].":</font>";
	    }
	    elseif ($chatrow["autorizacion"] == 1) {
	  	$name = "<font color=green>".$babblerow["usuario"].":</font>";
	    }
	    elseif ($chatrow["autorizacion"] == 2) {
	  	$name = "<font color=blue>".$babblerow["usuario"].":</font>";
	  	} else {
	  		$name = "".$babblerow["usuario"].":";
	  	}

		$fecha=$babblerow["fh_mensaje"];
    ereg( "([0-9]{2,2})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
   
        if ($babblerow["touser"] != "") { $spanbegin = "<span style=\"color: red;\">"; $spanend = "</span>"; } else { $spanbegin = ""; $spanend = ""; }
        if ($bg == 1) { $new = "<div class='mensajesch'>Por <b>".$name." el d&iacute;a ".$lafecha."</b><br> $spanbegin".$babblerow["mensaje"]."$spanend</div>\n";}
        


    $babblebox["content"] = $new . $babblebox["content"];
    }
    $babblebox["content"] .= "<div class='publicarch'><p><center><form action=\"index.php?do=chat\" method=\"post\"><br><input type=\"text\" name=\"mensaje\" size=\"40\" maxlength=\"150\" /> <input type=\"submit\" name=\"submit\" value=\"Enviar\" /> <input type=\"reset\" name=\"reset\" value=\"Limpiar\" /></form><br><b><font color=red>Porfavor no discutir en el chat. O seras baneado.</font></b></center></p>";

        $onlinequery = doquery("SELECT * FROM {{table}} WHERE UNIX_TIMESTAMP(chattime) >= '".(time()-90)."' AND charname!='Admin' ORDER BY charname", "usuarios");
        $babblebox["content"] .= "<table width=\"590px%\"><tr><tr><td>\n";
        $babblebox["content"] .= "<font color=#FFFFFF><b>Jugadores chateando (" . mysql_num_rows($onlinequery) . "):</b></font> ";
        while ($onlinerow = mysql_fetch_array($onlinequery)) { 
   $babblebox["content"] .= "<b>".$onlinerow["charname"]."" . "</b>, "; }
        $babblebox["content"] .= rtrim($townrow["whosonline"], ", ");
        $babblebox["content"] .= "</td></tr></table></div>\n";
    // Validación XHTML.
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    $page = $xml . gettemplate("chat");
    $page= parsetemplate($page, $babblebox);
    display($page , "Chat");}
	else {
	$babblebox["content"] .= "<div class='contenido2'>El chat esta cerrado temporalmente.</div>";
	$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n"
    . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n"
    . "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    $page = $xml . gettemplate("chat");
    $page= parsetemplate($page, $babblebox);
    display($page , "Chat");
	}

}
	
function cambiarcontrasenia()
{
  global $userrow;
 if (isset($_POST["submit"])) {
        extract($_POST);
        $userquery = doquery("SELECT * FROM {{table}} WHERE usuario='$usuario' LIMIT 1","usuarios");
        if (mysql_num_rows($userquery) != 1) { die("No hay cuentas con ese nombre de usuario."); }
        $userrow = mysql_fetch_array($userquery);
        if ($userrow["password"] != md5($oldpass)) { die("La contraseña antigua es incorrecta."); }
        if (preg_match("/[^A-z0-9_\-]/", $newpass1)==1) { die("La nueva contraseña debe ser alfanumérica."); }
        if ($newpass1 != $newpass2) { die("Las nuevas contraseñas no coinciden."); }
        $realnewpass = md5($newpass1);
        $updatequery = doquery("UPDATE {{table}} SET password='$realnewpass' WHERE usuario='$usuario' LIMIT 1","usuarios");
        if (isset($_COOKIE["dkgame"])) { setcookie("dkgame", "", time()-100000, "/", "", 0); }
        display("Tu contraseña ha cambiado.<br /><br />Fuiste desconectado del juego para prevenir errores.<br /><br />Please <a href=\"entrar.php?do=entrar\">Conectate</a> de nuevo para seguir jugando.","Cambiar Contraseña",false,false,false);
        die();
    }
    $page = gettemplate("cambiar");
    display($page, "Cambiar Contraseña"); 
    
}


function banco() { //Banco personal
	global $userrow, $numqueries;
	
	$intereses = intval($_POST['withdraw'] * 0.05); //Porcentaje de intereses

	$townquery = doquery("SELECT name,innprice FROM {{table}} WHERE latitude='".$userrow["latitude"]."' AND longitude='".$userrow["longitude"]."' LIMIT 1", "ciudades");
	if (mysql_num_rows($townquery) != 1) { display("<div class='contenido2'>Debes estar en la ciudad para entrar al banco.</div>", "Error"); }

		if (isset($_POST['banco'])) {
			$title = "Banco";

			if ($_POST['withdraw']) {
				if ($_POST['withdraw'] <= 0) 
					$page = "<div class='contenido2'>¡Tienes que retirar 1 o más de oro!</div>";
				elseif ($_POST['withdraw'] > $userrow['banco'])
					$page = "<div class='contenido2'>¡No tienes tanto oro en el banco!</div>";
				else {		
					$newgold = $userrow['gold'] + intval($_POST['withdraw'] - $intereses);
					$newbank = $userrow['banco'] - intval($_POST['withdraw']);
					doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
					doquery("UPDATE {{table}} SET banco='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
					$page = "<div class='contenido2'>Usted retiro $_POST[withdraw] de oro y se le restaron $intereses de oro por los intereses.";
					$page .= "<br />Puedes volver al <a href=index.php?do=banco>banco</a> o a la <a href=index.php>ciudad</a></div>";
				}

			} elseif ($_POST['deposit']) {
				if ($_POST['deposit'] <= 0) 
					$page = "<div class='contenido2'>Debes introducir una cantidad superior a 0</div>";
				elseif ($_POST['deposit'] > $userrow['gold'])
					$page = "<div class='contenido2'>No tienes tanto oro</div>";
				else {
					$newgold = $userrow['gold'] - intval($_POST['deposit']);
					$newbank = $userrow['banco'] + intval($_POST['deposit']);
					doquery("UPDATE {{table}} SET gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
					doquery("UPDATE {{table}} SET banco='$newbank' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
					$page = "<div class='contenido2'>Has depositado $_POST[deposit] de oro!";
					$page .= "<br />Puedes volver al <a href=index.php?do=banco>banco</a> o a la <a href=index.php>ciudad</a></div>";
				}
			}
		} else {
			$title ="Banco";
			$page = "<div class='titulo'>Banco</div>";
			$page .= "<div class='contenido2'>Tienes $userrow[banco] de oro en el banco. <br />Los intereses de retirada de oro actualmente son del 5%";
			$page .= "<form action=index.php?do=banco method=post><br />";
			$page .= "Depositar <input type=text name=deposit><br />";
			$page .= "Retirar <input type=text name=withdraw><br />";
			$page .= "<input type=submit value=Confirmar name=banco></form>";
			$page .= "<br />Ahora puedes volver a la <a href=index.php>ciudad</a></div>";
		}
            
	display($page, $title);
    
}
?>