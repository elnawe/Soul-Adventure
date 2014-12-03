<?php // curar.php :: Curar, Habilidades Rápidas
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
function healspells($id) {
    
    global $userrow;
    
    $userspells = explode(",",$userrow["spells"]);
    $spellquery = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "habilidades");
    $spellrow = mysql_fetch_array($spellquery);
    
    // Errores.
    $spell = false;
    foreach ($userspells as $a => $b) {
        if ($b == $id) { $spell = true; }
    }
    if ($spell != true) { display("<div class='contenido2'>Todavia no has aprendido esta habilidad.</div>", "Error"); die(); }
    if ($spellrow["type"] != 1) { display("<div class='contenido2'>No es un habilidad de curación.</div>", "Error"); die(); }
    if ($userrow["currentmp"] < $spellrow["mp"]) { display("<div class='contenido2'>No tienes la cantidad necesario de Puntos de Magia para usar esta habilidad.</div>", "Error"); die(); }
    if ($userrow["currentaction"] == "Peleando") { display("<div class='contenido2'>No puedes usar la lista de Habilidades rápidas durante una pelea.</div>", "Error"); die(); }
    if ($userrow["currenthp"] == $userrow["maxhp"]) { display("<div class='contenido2'>Tus Puntos de Vida están al máximo.</div>", "Error"); die(); }
    
    $newhp = $userrow["currenthp"] + $spellrow["attribute"];
    if ($userrow["maxhp"] < $newhp) { $spellrow["attribute"] = $userrow["maxhp"] - $userrow["currenthp"]; $newhp = $userrow["currenthp"] + $spellrow["attribute"]; }
    $newmp = $userrow["currentmp"] - $spellrow["mp"];
    
    $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp', currentmp='$newmp' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
    
    display("<div class='contenido2'>Usas ".$spellrow["name"]." y recuperas ".$spellrow["attribute"]." Puntos de Vida. Ahora puedes continuar <a href=\"index.php\">explorando</a>.</div>", "Curando");
    die();
    
}

?>