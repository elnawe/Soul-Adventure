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
 global $controlrow;
    
    $statquery = doquery("SELECT * FROM {{table}} ORDER BY nivel DESC LIMIT 1", "monstruos");
    $statrow = mysql_fetch_array($statquery);
    
    $query = doquery("SELECT id,name,nivel FROM {{table}} ORDER BY id", "monstruos");
    $page = "<b><u>Editar Monstruos</u></b><br />";
    
    if (($controlrow["gamesize"]/5) != $statrow["nivel"]) {
        $page .= "<span class=\"highlight\">Nota:</span> Tus monstruos de nivel más alto no concuardan con el tamaño del mapa. Los monstruos de nivel más altos podrian ser ".($controlrow["gamesize"]/5).", los tuyos serian ".$statrow["nivel"].". Por favor, arregle esto antes de abrir su juego al público.<br /><br />";
    } else { $page .= "El nivel del monstruo y el tamaño del mapa concuerdan.<br /><br />"; }
    
    $template = gettemplate("admin/paginas/monstruo");
	$page = parsetemplate($template,$controlrow);
    $page = $xml . $page;
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\">".$row["name"]."</a></td><td style=\"background-color: #eeeeee;\">".$row["nivel"]."</a></td></tr>\n"; }
       
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">No se encontraron monstruos.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Administración-Monstruos");
	
	?>