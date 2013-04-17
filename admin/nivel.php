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
$query = doquery("SELECT id FROM {{table}} ORDER BY id", "niveles");
$row = mysql_fetch_array($query);    
$template = gettemplate("admin/paginas/nivel");
$page = parsetemplate($template, $controlrow);
    $page = $xml . $page;

 $count = 1;
	
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<b>".$row["id"]."</b>,\n"; 
		 }
    }

    admindisplay($page, "Administración-Niveles");
?>